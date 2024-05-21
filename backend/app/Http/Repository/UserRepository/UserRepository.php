<?php
namespace App\Http\Repository\UserRepository;

use App\Models\User;

class UserRepository implements UserInterface {
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function query(): ?object
    {
        $user = $this->user->query();

        return $user;
    }

    public function index(): ?object
    {
        $user = $this->user->all();

        return $user;
    }

    public function create(array $data): object
    {
        $user = $this->user->create($data);

        return $user;

    }

    public function detail(int $id, array $withData = []): ?object
    {
        $user = $this->user->find($id);

        return $user;
    }

    public function detailByEmail(string $email): ?object
    {
        $user = $this->user->where('email', $email)->first();

        return $user;
    }

    public function update(int $id, array $data): object
    {
        $user = $this->user->find($id);

        $user->update($data);

        return $user;
    }

    public function updateOrCreate(int $id, array $findData, array $bodyDaya): object
    {
        $user = $this->user->find($id);

        $user->updateOrCreate($findData, $bodyDaya);

        return $user;
    }

    public function delete(int $id): object
    {
        $user = $this->user->find($id);

        $user->delete();

        return $user;
    }
}
