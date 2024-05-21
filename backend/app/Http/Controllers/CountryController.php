<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryRequest;
use App\Http\Services\CountryService;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    private $CountryService;

    public function __construct(CountryService $CountryService)
    {
        $this->CountryService = $CountryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $CountryService = $this->CountryService->index();

            if (!$CountryService['status']) {
                if ($CountryService['response'] == "validation") {
                    return $this->errorvalidator($CountryService['errors'], $CountryService['message']);
                }
                else {
                    return $this->errorServer($CountryService['errors']);
                }
            }

            return $this->success(
                $CountryService['response'],
                $CountryService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(CountryRequest $CountryRequest)
    {
        try {
            $CountryService = $this->CountryService->create($CountryRequest->all());

            if (!$CountryService['status']) {
                if ($CountryService['response'] == "validation") {
                    return $this->errorvalidator($CountryService['errors'], $CountryService['message']);
                }
                else {
                    return $this->errorServer($CountryService['errors']);
                }
            }

            return $this->success(
                $CountryService['response'],
                $CountryService['data'],
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
            $CountryService = $this->CountryService->detail($id);

            if (!$CountryService['status']) {
                if ($CountryService['response'] == "validation") {
                    return $this->errorvalidator($CountryService['errors'], $CountryService['message']);
                }
                else {
                    return $this->errorServer($CountryService['errors']);
                }
            }

            return $this->success(
                $CountryService['response'],
                $CountryService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CountryRequest $CountryRequest, $id)
    {        
        try {
            $CountryService = $this->CountryService->update($id, $CountryRequest->all());

            if (!$CountryService['status']) {
                if ($CountryService['response'] == "validation") {
                    return $this->errorvalidator($CountryService['errors'], $CountryService['message']);
                }
                else {
                    return $this->errorServer($CountryService['errors']);
                }
            }

            return $this->success(
                $CountryService['response'],
                $CountryService['data'],
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
            $CountryService = $this->CountryService->delete($id);

            if (!$CountryService['status']) {
                if ($CountryService['response'] == "validation") {
                    return $this->errorvalidator($CountryService['errors'], $CountryService['message']);
                }
                else {
                    return $this->errorServer($CountryService['errors']);
                }
            }

            return $this->success(
                $CountryService['response'],
                $CountryService['data'],
            );

        } catch (\Throwable $th) {
            return $this->errorServer($th->getMessage());
        }
    }
}
