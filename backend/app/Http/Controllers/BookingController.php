<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Http\Requests\BookingRequestUpdate;
use App\Http\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    private $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $bookingService = $this->bookingService->index();

            if (!$bookingService['status']) {
                if ($bookingService['response'] == "validation") {
                    return $this->errorvalidator($bookingService['errors'], $bookingService['message']);
                }
                else {
                    return $this->errorServer($bookingService['errors']);
                }
            }

            return $this->success(
                $bookingService['response'],
                $bookingService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(BookingRequest $bookingRequest)
    {
        try {
            $bookingService = $this->bookingService->create($bookingRequest->all());

            if (!$bookingService['status']) {
                if ($bookingService['response'] == "validation") {
                    return $this->errorvalidator($bookingService['errors'], $bookingService['message']);
                }
                else {
                    return $this->errorServer($bookingService['errors']);
                }
            }

            return $this->success(
                $bookingService['response'],
                $bookingService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function detail(string $id)
    {
        try {
            $bookingService = $this->bookingService->detail($id);

            if (!$bookingService['status']) {
                if ($bookingService['response'] == "validation") {
                    return $this->errorvalidator($bookingService['errors'], $bookingService['message']);
                }
                else {
                    return $this->errorServer($bookingService['errors']);
                }
            }

            return $this->success(
                $bookingService['response'],
                $bookingService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookingRequestUpdate $bookingRequest, $id)
    {        
        try {
            $bookingService = $this->bookingService->update($id, $bookingRequest->all());

            if (!$bookingService['status']) {
                if ($bookingService['response'] == "validation") {
                    return $this->errorvalidator($bookingService['errors'], $bookingService['message']);
                }
                else {
                    return $this->errorServer($bookingService['errors']);
                }
            }

            return $this->success(
                $bookingService['response'],
                $bookingService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        try {
            $bookingService = $this->bookingService->delete($id);

            if (!$bookingService['status']) {
                if ($bookingService['response'] == "validation") {
                    return $this->errorvalidator($bookingService['errors'], $bookingService['message']);
                }
                else {
                    return $this->errorServer($bookingService['errors']);
                }
            }

            return $this->success(
                $bookingService['response'],
                $bookingService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());
        }
    }
}
