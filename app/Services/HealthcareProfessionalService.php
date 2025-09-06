<?php

namespace App\Services;

use App\Repositories\HealthcareProfessionalRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\HealthcareProfessional;
use Illuminate\Database\Eloquent\Collection;

class HealthcareProfessionalService
{
    public function __construct(private HealthcareProfessionalRepository $hcpRepo) {}

    /**
     * @param int $perPage
     *
     * @return LengthAwarePaginator
     */
    public function getAllPaginated(int $perPage = 20): LengthAwarePaginator
    {
        return $this->hcpRepo->paginate($perPage);
    }

    /**
     * @param int $id
     *
     * @return HealthcareProfessional|null
     */
    public function getById(int $id): ?HealthcareProfessional
    {
        return $this->hcpRepo->findById($id);
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->hcpRepo->all();
    }
}
