<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Models\Charge;

class ChargeCalculator
{
    /**
     * Calculate taxes and fees for a given amount.
     *
     * @param float $amount The base amount (or total amount if inclusive taxes exist)
     * @param Collection $charges Collection of Charge models
     * @param string|null $orderType Context of calculation ('dining_in', 'takeaway', 'delivery') or null for all
     * @return array
     */
    public function calculate(float $amount, Collection $charges, ?string $orderType = null): array
    {
        // Filter charges based on order type
        $applicableCharges = $charges->filter(function ($charge) use ($orderType) {
            // If no specific order type is provided, we include all charges (e.g. for admin display)
            if (is_null($orderType)) {
                return true; 
            }
            
            // If order type is provided, check if the charge applies to it
            // ensuring applicable_order_types is an array (it should be cast in model)
            $types = $charge->applicable_order_types ?? [];
            return is_array($types) && in_array($orderType, $types);
        });

        $charges = $applicableCharges;

        $subtotal = $amount;
        $totalTax = 0;
        $totalFees = 0;
        $breakdown = [];

        // 1. Separate charges by type to handle inclusive vs exclusive correctly
        $inclusiveTaxes = $charges->where('classification', 'tax')->where('is_inclusive', true);
        $exclusiveCharges = $charges->reject(function ($charge) {
            return $charge->classification === 'tax' && $charge->is_inclusive;
        });

        // 2. Handle Inclusive Taxes (Back-calculate from the amount)
        // Formula: Base = Amount / (1 + Sum(TaxRates))
        if ($inclusiveTaxes->isNotEmpty()) {
            $totalInclusiveRate = $inclusiveTaxes->sum(function ($tax) {
                return $tax->type === 'percentage' ? $tax->value / 100 : 0;
            });

            // Note: Fixed inclusive taxes are weird and rare, assuming inclusive is mostly percentage for VAT.
            // If there's a fixed inclusive tax, it subtracts from the base directly, but that's complex algebraically mixed with %.
            // For now, we'll treat fixed inclusive as a direct subtraction from the base *after* rate calculation effectively.
            
            // Simplified for standard VAT use case:
            $baseAmount = $amount / (1 + $totalInclusiveRate);
            $subtotal = $baseAmount; 

            foreach ($inclusiveTaxes as $tax) {
                $taxAmount = 0;
                if ($tax->type === 'percentage') {
                    $taxAmount = $baseAmount * ($tax->value / 100);
                } else {
                    // Fixed inclusive is treated as part of the base that is engaged.
                    // This is an edge case. For safety, let's treat fixed inclusive as simple subtraction from the pot?
                    // Usually VAT is %.
                    $taxAmount = $tax->value;
                    $subtotal -= $taxAmount; // Adjust subtotal down further? 
                    // Let's stick to standard percentage for inclusive for now as it's 99% of cases.
                }

                $totalTax += $taxAmount;
                $breakdown[] = [
                    'name' => $tax->name,
                    'amount' => round($taxAmount, 2),
                    'type' => 'tax',
                    'is_inclusive' => true
                ];
            }
        }

        // 3. Handle Exclusive Charges (Taxes & Fees added ON TOP of the Base)
        // Note: Do exclusive taxes apply to the Base ($subtotal) or the original input $amount?
        // Usually, Service Charge is on the Subtotal. VAT (Exclusive) is on the Subtotal.
        // If we extracted inclusive tax, the "Price" of the item is $subtotal.
        // So exclusive charges should be based on $subtotal.

        foreach ($exclusiveCharges as $charge) {
            $chargeAmount = 0;

            if ($charge->type === 'percentage') {
                $chargeAmount = $subtotal * ($charge->value / 100);
            } else {
                $chargeAmount = $charge->value;
            }

            if ($charge->classification === 'tax') {
                $totalTax += $chargeAmount;
            } else {
                $totalFees += $chargeAmount;
            }

            $breakdown[] = [
                'name' => $charge->name,
                'amount' => round($chargeAmount, 2),
                'type' => $charge->classification,
                'is_inclusive' => false
            ];
        }

        $grandTotal = $subtotal + $totalTax + $totalFees;
        if ($inclusiveTaxes->isNotEmpty()) {
            // If inclusive, the grand total should theoretically match the input amount + exclusive charges.
            // Because inclusive tax was already "in" the input amount.
            // Re-sum to be safe: Base + Tax + Fees.
            // Example: 115 Input (15% Inc). Base = 100. Tax = 15.
            // Exclusive Fee 10%: 10% of 100 = 10.
            // Total = 100 + 15 + 10 = 125.
            
            // Logic check:
            // Input: 115.
            // Calculated Base: 100.
            // Logic: Total = Base + (Inclusive Tax) + (Exclusive Charges).
            // Total = 100 + 15 + 0 = 115. Correct.
        }

        return [
            'subtotal' => round($subtotal, 2),
            'total_tax' => round($totalTax, 2),
            'total_fees' => round($totalFees, 2),
            'grand_total' => round($grandTotal, 2),
            'breakdown' => $breakdown
        ];
    }
}
