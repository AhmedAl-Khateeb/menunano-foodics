<?php

namespace App\Services;

use App\Helpers\ImageManager;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        private readonly ImageManager $imageManager,
    ) {
    }

    public function index()
    {
        return User::query()
            ->with(['creator', 'branch'])
            ->latest()
            ->paginate(10);
    }

    public function store(array $data): User
    {
        $imagePath = null;
        if (!empty($data['image'])) {
            $imagePath = $this->imageManager->uploadImage('users', $data['image']);
        }
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
            'image' => $imagePath,
            'created_by' => auth()->id(),
            'branch_id' => $data['branch_id'],
        ]);

        $this->syncRole($user, $data['role_id']);

        return $user;
    }

    public function update(User $user, array $data): User
    {
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'branch_id' => $data['branch_id'],
        ]);

        if (!empty($data['image'])) {
            if ($user->image) {
                $this->imageManager->deleteImage($user->image);
            }

            $updateData['image'] = $this->imageManager->uploadImage('users', $data['image']);
        }

        if (!empty($data['password'])) {
            $user->update([
                'password' => Hash::make($data['password']),
            ]);
        }

        $this->syncRole($user, $data['role_id']);

        return $user;
    }

    public function delete(User $user): void
    {
        if ($user->id == auth()->id()) {
            throw new \Exception('لا يمكنك حذف نفسك');
        }

        if ($user->image) {
            $this->imageManager->deleteImage($user->image);
        }

        $user->delete();
    }

    private function syncRole(User $user, mixed $roleId): void
    {
        if (auth()->user()->role === 'admin') {
            $user->role = $roleId;
            $user->save();

            return;
        }

        if (auth()->user()->role === 'super_admin') {
            $role = \Spatie\Permission\Models\Role::find($roleId);
            if ($role) {
                if ($user->exists) {
                    $user->syncRoles([$role]);
                } else {
                    $user->assignRole($role);
                }
            }
        }
    }
}
