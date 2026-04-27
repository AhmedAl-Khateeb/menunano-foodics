<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function webLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()
                ->withErrors(['login' => 'بيانات الدخول غير صحيحة'])
                ->withInput();
        }

        $request->session()->regenerate();

        $user = auth()->user();

        if ($user->role === 'super_admin') {
            return redirect()->route('admins.index');
        }

        if (in_array($user->role, ['cashier', 'staff', 'employee'])) {
            return redirect()->route('pos.index');
        }

        return redirect()->route('dashboard');
    }

    public function webLogout(Request $request)
    {
        $request->validate([
            'ending_cash' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        $user = auth()->user();

        $activeShift = Shift::where('user_id', $user->id)
            ->where('status', 'active')
            ->latest()
            ->first();

        if ($activeShift) {
            if (!$request->filled('ending_cash')) {
                return back()->with('error', 'يجب إدخال رصيد نهاية الدرج قبل تسجيل الخروج.');
            }

            app(\App\Services\ShiftService::class)->closeShift($activeShift, [
                'ending_cash' => $request->ending_cash,
                'notes' => $request->notes,
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function logoutShiftInfo()
    {
        $activeShift = Shift::where('user_id', auth()->id())
            ->where('status', 'active')
            ->latest()
            ->first();

        if (!$activeShift) {
            return response()->json([
                'has_shift' => false,
            ]);
        }

        $expectedCash = app(\App\Services\ShiftService::class)
            ->calculateExpectedCashForShift($activeShift);

        $startingCash = (float) $activeShift->starting_cash;
        $cashSales = $expectedCash - $startingCash;

        return response()->json([
            'has_shift' => true,
            'shift_id' => $activeShift->id,
            'starting_cash' => number_format($startingCash, 2, '.', ''),
            'cash_sales' => number_format($cashSales, 2, '.', ''),
            'expected_cash' => number_format($expectedCash, 2, '.', ''),
        ]);
    }
}
