<?php

namespace App\Helpers;

use App\Models\Unit;

class UnitHelper
{
    /**
     * Convert value from one unit to another.
     *
     * @param float $value
     * @param Unit $fromUnit
     * @param Unit $toUnit
     * @return float|null
     */
    public static function convert($value, Unit $fromUnit, Unit $toUnit)
    {
        if ($fromUnit->id === $toUnit->id) {
            return $value;
        }

        if ($fromUnit->type !== $toUnit->type) {
            return null; // Cannot convert between different types
        }

        // Convert 'from' unit to base unit
        $baseValue = $value;
        if ($fromUnit->base_unit_id) {
            $baseValue = $value * $fromUnit->conversion_rate;
        }

        // Convert base unit to 'to' unit
        if ($toUnit->base_unit_id) {
            return $baseValue / $toUnit->conversion_rate;
        }

        return $baseValue;
    }

    /**
     * Format value with unit symbol.
     *
     * @param float $value
     * @param Unit $unit
     * @return string
     */
    public static function format($value, Unit $unit)
    {
        $formattedValue = $unit->allow_decimal ? (float)$value : (int)$value;
        return $formattedValue . ' ' . $unit->symbol;
    }
}
