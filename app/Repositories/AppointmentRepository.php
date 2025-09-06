<?php

namespace App\Repositories;

use App\Models\Appointment;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class AppointmentRepository
{
    /**
     * @param int $id
     *
     * @return Appointment|null
     */
    public function findById(int $id): ?Appointment
    {
        return Appointment::with('professional')->find($id);
    }

    /**
     * @param int $userId
     * @param int $perPage
     *
     * @return Appointment
     */
    public function forUser(int $userId, int $perPage = 20): Appointment
    {
        return Appointment::with('professional')
            ->where('user_id', $userId)
            ->orderBy('appointment_start_time', 'desc')
            ->paginate($perPage);
    }

    /**
     * @param array $data
     *
     * @return Appointment
     */
    public function create(array $data): Appointment
    {
        return Appointment::create($data);
    }

    /**
     * @param int $hcpId
     * @param Carbon $start
     * @param Carbon $end
     *
     * @return bool
     */
    public function hasOverlap(int $hcpId, Carbon $start, Carbon $end): bool
    {
        return Appointment::where('healthcare_professional_id', $hcpId)
            ->where('status', Appointment::SATATUS_BOOKED)
            ->where(function($q) use ($start, $end) {
                $q->whereBetween('appointment_start_time', [$start, $end->copy()->subSecond(1)])
                    ->orWhereBetween('appointment_end_time', [$start, $end])
                  ->orWhere(function($qq) use ($start, $end) {
                      $qq->where('appointment_start_time', '<=', $start)
                         ->where('appointment_end_time', '>=', $end);
                  });
            })
            ->exists();
    }
}
