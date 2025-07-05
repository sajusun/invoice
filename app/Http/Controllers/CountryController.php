<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CountryController extends Controller
{
    private string $nameUrl='https://restcountries.com/v3.1/all?fields=name,idd';
    private string $currencyUrl='https://restcountries.com/v3.1/all?fields=currencies';
    public function getCountries()
    {
        // Cache for 24 hours (1440 minutes)
        $countries = Cache::remember('countries_list', 1440, function () {
            $response = Http::get(url($this->nameUrl));

            if ($response->failed()) {
                return [];
            }

            $data = $response->json();

            // Build clean array of country name & phone code
            $countryList = [];

            foreach ($data as $country) {
                if (isset($country['idd']['root'])) {
                    $code = $country['idd']['root'];
                    if (!empty($country['idd']['suffixes'])) {
                        $code .= $country['idd']['suffixes'][0];
                    }
                    $countryList[] = [
                        'name' => $country['name']['common'],
                        'code' => $code
                    ];
                }
            }

            // Sort by name
            usort($countryList, function ($a, $b) {
                return strcmp($a['name'], $b['name']);
            });

            return $countryList;
        });

        //return response()->json($countries);
        return $countries;
    }

    public function getCurrencies()
    {
        // Cache for 24 hours
        $currencies = Cache::remember('currency_list', 1440, function () {
            $response = Http::get($this->currencyUrl);

            if ($response->failed()) {
                return [];
            }

            $data = $response->json();

            $currencyList = [];

            foreach ($data as $country) {
                if (isset($country['currencies']) && is_array($country['currencies'])) {
                    foreach ($country['currencies'] as $code => $details) {
                        $currencyList[$code] = [
                            'code' => $code,
                            'name' => $details['name'] ?? $code,
                            'symbol' => $details['symbol'] ?? ''
                        ];
                    }
                }
            }

            // Remove duplicates by using array_values
            return array_values($currencyList);
        });

        return response()->json($currencies);
    }

}

