<?php
namespace App\Http\Repository\CountryRepository;

use App\Models\Country;

class CountryRepository implements CountryInterface {
    private $country;

    public function __construct(Country $country)
    {
        $this->country = $country;
    }

    public function query(): ?object
    {
        $country = $this->country->query();

        return $country;
    }

    public function index(): ?object
    {
        $country = $this->country->all();

        return $country;
    }

    public function create(array $data): object
    {
        $country = $this->country->create($data);

        return $country;

    }

    public function detail(int $id, array $withData = []): ?object
    {
        $country = $this->country->find($id);

        return $country;
    }

    public function update(int $id, array $data): object
    {
        $country = $this->country->find($id);

        $country->update($data);

        return $country;
    }

    public function updateOrCreate(int $id, array $findData, array $bodyDaya): object
    {
        $country = $this->country->find($id);

        $country->updateOrCreate($findData, $bodyDaya);

        return $country;
    }

    public function delete(int $id): object
    {
        $country = $this->country->find($id);

        $country->delete();

        return $country;
    }
}
