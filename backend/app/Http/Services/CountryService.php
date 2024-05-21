<?php
namespace App\Http\Services;

use App\Http\Repository\CountryRepository\CountryInterface;
use App\Http\Repository\UserRepository\UserInterface;
use App\Models\Country;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CountryService {
    private $countryInterface;

    public function __construct(CountryInterface $countryInterface)
    {
        $this->countryInterface = $countryInterface;
    }

    public function index(): array
    {

        $country = $this->countryInterface->index();

        $return = [
            'status' => true,
            'response' => 'get',
            'data' => $country
        ];

        return $return;
    }

    public function create($data): array
    {
        $return = [];

        $findByIso2 = $this->countryInterface->query()->where('iso2', strtoupper($data['iso2']))->first();

        if($findByIso2) {
            $return = [
                'status' => false,
                'response' => 'validation',
                'message' => null,
                'errors' => [
                    'Country with ISO2 already created!'
                ]
            ];

            return $return;
        }

        $country = $this->countryInterface->create($data);

        $return = [
            'status' => true,
            'response' => 'created',
            'data' => $country
        ];

        return $return;

    }

    public function detail($id): array
    {
        $country = $this->countryInterface->detail($id);

        if (!$country) {
            $return = [
                'status' => false,
                'response' => 'validation',
                'message' => null,
                'errors' => [
                    'Country ID not found!'
                ]
            ];
        }
        else {
            $return = [
                'status' => true,
                'response' => 'get',
                'data' => $country
            ];
        }

        return $return;
    }

    public function update($id, $data): array
    {
        $countryById = $this->countryInterface->detail($id);

        if (!$countryById) {
            $return = [
                'status' => false,
                'response' => 'validation',
                'message' => null,
                'errors' => [
                    'Country ID not found!'
                ]
            ];

            return $return;
        }

        $country = $this->countryInterface->update($id, $data);

        $return = [
            'status' => true,
            'response' => 'updated',
            'data' => $country
        ];
        
        return $return;
    }

    public function delete($id): array
    {

        $countryById = $this->countryInterface->detail($id);

        if (!$countryById) {
            $return = [
                'status' => false,
                'response' => 'validation',
                'message' => null,
                'errors' => [
                    'Country ID not found!'
                ]
            ];
        }
        else {

            $country = $this->countryInterface->delete($id);

            $return = [
                'status' => true,
                'response' => 'deleted',
                'data' => $country
            ];
        }

        return $return;
    }
}
