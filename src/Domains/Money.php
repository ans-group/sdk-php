<?php

namespace UKFast\SDK\Domains;

/**
 * Adds and subtracts prices given as decimal strings (e.g. "22.67") in whole pennies, so the results are exact and
 * match what the API expects back when a price is confirmed.
 */
class Money
{
    /**
     * @param string|int|float $first
     * @param string|int|float $second
     * @return string
     */
    public static function add($first, $second)
    {
        return self::format(self::pennies($first) + self::pennies($second));
    }

    /**
     * @param string|int|float $first
     * @param string|int|float $second
     * @return string
     */
    public static function subtract($first, $second)
    {
        return self::format(self::pennies($first) - self::pennies($second));
    }

    private static function pennies($price)
    {
        return (int) round(((float) $price) * 100);
    }

    private static function format($pennies)
    {
        return number_format($pennies / 100, 2, '.', '');
    }
}
