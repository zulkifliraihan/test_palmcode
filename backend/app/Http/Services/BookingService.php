<?php
namespace App\Http\Services;

use App\Http\Repository\BookingRepository\BookingInterface;
use App\Http\Repository\CountryRepository\CountryInterface;
use App\Http\Repository\UserRepository\UserInterface;
use App\Models\Booking;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class BookingService {
    private $bookingInterface, $userInterface, $countryInterface;

    public function __construct(
        BookingInterface $bookingInterface, 
        UserInterface $userInterface,
        CountryInterface $countryInterface,
    )
    {
        $this->bookingInterface = $bookingInterface;
        $this->userInterface = $userInterface;
        $this->countryInterface = $countryInterface;
    }

    public function index(): array
    {

        $booking = $this->bookingInterface->index();

        $return = [
            'status' => true,
            'response' => 'get',
            'data' => $booking
        ];

        return $return;
    }

    public function create($data): array
    {
        $return = [];

        $findCountry = $this->countryInterface->detail($data['country_id']);
        if(!$findCountry) {
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

        $data['whatsapp_number'] = str_replace(["+", "-", " ", "_"], "", $data['whatsapp_number']);
        
        $user = $this->userInterface->query()->updateOrCreate(
            [
                'email' => $data['email']
            ],
            [
                'name' => $data['name'],
                'password' => Hash::make('password'),
                'whatsapp_number' => $data['whatsapp_number'],
            ]
        );

        $data['user_id'] = $user->id;

        $booking = $this->bookingInterface->create($data);

        if($data['identification_id']) {
            $user
            ->addMediaFromRequest('identification_id')
            ->usingName((string) str()->ulid())
            ->toMediaCollection('identification');
        }

        $return = [
            'status' => true,
            'response' => 'created',
            'data' => $booking
        ];

        return $return;

    }

    public function detail($id): array
    {
        $booking = $this->bookingInterface->detail($id);

        if (!$booking) {
            $return = [
                'status' => false,
                'response' => 'validation',
                'message' => null,
                'errors' => [
                    'Booking ID not found!'
                ]
            ];
        }
        else {
            $return = [
                'status' => true,
                'response' => 'get',
                'data' => $booking
            ];
        }

        return $return;
    }

    public function update($id, $data): array
    {
        $bookingById = $this->bookingInterface->detail($id);

        if (!$bookingById) {
            $return = [
                'status' => false,
                'response' => 'validation',
                'message' => null,
                'errors' => [
                    'Booking ID not found!'
                ]
            ];

            return $return;
        }

        $user = $this->userInterface->query()->updateOrCreate(
            [
                'email' => $data['email']
            ],
            [
                'name' => $data['name'],
                'password' => Hash::make('password'),
                'whatssapp_number' => $data['whatssapp_number'],
            ]
        );

        $data['user_id'] = $user->id;

        $booking = $this->bookingInterface->update($id, $data);

        if($data['identification_id']) {
            $user
            ->addMediaFromRequest('identification_id')
            ->usingName((string) str()->ulid())
            ->toMediaCollection('identification');
        }

        $return = [
            'status' => true,
            'response' => 'updated',
            'data' => $booking
        ];
        
        return $return;
    }

    public function delete($id): array
    {

        $bookingById = $this->bookingInterface->detail($id);

        if (!$bookingById) {
            $return = [
                'status' => false,
                'response' => 'validation',
                'message' => null,
                'errors' => [
                    'Booking ID not found!'
                ]
            ];
        }
        else {

            $booking = $this->bookingInterface->delete($id);

            $return = [
                'status' => true,
                'response' => 'deleted',
                'data' => $booking
            ];
        }

        return $return;
    }


}
