<?php


namespace App\Provider;


class LocaleCurrencyProvider
{
    private static $defaultCurrency = 'USD';
    private static $localeCurrency = array(
        'en' => 'USD',
        'pl' => 'PLN',
    );

    public static function get(string $locale) : string
    {
        if (!self::exist($locale)) {
            return self::$defaultCurrency;
        }

        return self::$localeCurrency[$locale];
    }

    private static function exist(string $locale): bool
    {
        return isset(self::$localeCurrency[$locale]);
    }
}