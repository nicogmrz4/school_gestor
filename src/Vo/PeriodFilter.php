<?php

namespace App\Vo;

class PeriodFilter
{
    const MONTHLY = 1;
    const BIMESTER = 2;
    const TRIMESTER = 3;
    const QUARTER = 4;

    public int $value;

    public function __construct(int $value = self::MONTHLY) {
        try {
            if (!in_array($value, [self::MONTHLY, self::BIMESTER,self::TRIMESTER, self::QUARTER])) {
                throw new \Exception('Invalid period');
            }
            $this->value = $value;
        } catch (\Exception $e) {
            $this->value = self::MONTHLY;
        }
    }
}