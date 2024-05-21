<?php
namespace App\Http\Repository\BookingRepository;

use App\Models\Booking;

class BookingRepository implements BookingInterface {
    private $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function query(): ?object
    {
        $booking = $this->booking->query();

        return $booking;
    }

    public function index(): ?object
    {
        $booking = $this->booking->all();

        return $booking;
    }

    public function create(array $data): object
    {
        $booking = $this->booking->create($data);

        return $booking;

    }

    public function detail(int $id, array $withData = []): ?object
    {
        $booking = $this->booking->find($id);

        return $booking;
    }

    public function update(int $id, array $data): object
    {
        $booking = $this->booking->find($id);

        $booking->update($data);

        return $booking;
    }

    public function updateOrCreate(int $id, array $findData, array $bodyDaya): object
    {
        $booking = $this->booking->find($id);

        $booking->updateOrCreate($findData, $bodyDaya);

        return $booking;
    }

    public function delete(int $id): object
    {
        $booking = $this->booking->find($id);

        $booking->delete();

        return $booking;
    }
}
