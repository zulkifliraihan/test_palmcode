<?php
namespace App\Http\Repository\CountryRepository;

interface CountryInterface {
    public function query(): ?object;
    public function index(): ?object;
    public function create(array $data): object;
    public function detail(int $id, array $withData = []): ?object;
    public function update(int $id, array $data): object;
    public function updateOrCreate(int $id, array $findData, array $bodyDaya): object;
    public function delete(int $id): object;
}
