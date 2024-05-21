<?php

namespace Database\Seeders;

use App\Models\Country;
use GuzzleHttp\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client = new Client();

        $dataCountries = json_decode($client->get("http://country.io/names.json")->getBody()->getContents(), true);
        $dataPhoneCode = json_decode($client->get("http://country.io/phone.json")->getBody()->getContents(), true);
        $dataIso3 = json_decode($client->get("http://country.io/iso3.json")->getBody()->getContents(), true);
        $dataCapital = json_decode($client->get("http://country.io/capital.json")->getBody()->getContents(), true);
        $dataCurrency = json_decode($client->get("http://country.io/currency.json")->getBody()->getContents(), true);
        $dataFlag = json_decode($client->get("https://restcountries.com/v3.1/all")->getBody()->getContents(), true);
    
        foreach ($dataCountries as $countryCode => $countryName) {
            foreach ($dataFlag as $keyFlag => $valueFlag) {
                if($valueFlag['cca2'] == $countryCode) {
                    $phoneCode = $dataPhoneCode[$countryCode];
                    $phoneCode = str_replace(["+", "-", "_"], "", $phoneCode);
                    $item = [];
                    $item['name'] = $countryName;
                    $item['capital'] = $dataCapital[$countryCode] ?? null;
                    $item['iso2'] = $countryCode;
                    $item['iso3'] = $dataIso3[$countryCode] ?? null;
                    $item['phone_code'] = $phoneCode ?? null;
                    $item['currency'] = $dataCurrency[$countryCode] ?? null;
                    $item['flag'] = $valueFlag['flag'];
    
                    Country::firstOrCreate($item);
                }
            }
        }
    }
}
