<?php

namespace App\Repositories;

use App\Models\HealthcareProfessional;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class HealthcareProfessionalRepository
{
    /**
     * @param int $perPage
     *
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 20): LengthAwarePaginator
    {
        return HealthcareProfessional::paginate($perPage);
    }

    /**
     * @param int $id
     *
     * @return HealthcareProfessional|null
     */
    public function findById(int $id): ?HealthcareProfessional
    {
        return HealthcareProfessional::find($id);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return HealthcareProfessional::all();
    }
}
