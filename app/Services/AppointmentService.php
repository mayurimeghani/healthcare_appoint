<?php

namespace App\Services;

use App\Repositories\AppointmentRepository;
use App\Models\Appointment;
use App\Exceptions\BusinessException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AppointmentService
{
    public function __construct(private AppointmentRepository $appointments) {}

    /**
     * Book appointment
     *
     * @param mixed $user
     * @param int $hcpId
     * @param string $start
     * @param string $end
     * @param string|null $notes
     *
     * @return Appointment
     */
    public function book($user, int $hcpId, string $start, string $end, ?string $notes = null): Appointment
    {
        $start = Carbon::parse($start);
        $end   = Carbon::parse($end);

        if ($start->lte(now())) {
            throw new BusinessException(trans('error_message.date_sholud_be_future'));
        }

        if ($end->lte($start)) {
            throw new BusinessException(trans('error_message.end_date_should_after_start'));
        }

        if ($this->appointments->hasOverlap($hcpId, $start, $end)) {
            throw new BusinessException(trans('error_message.professional_not_available.'));
        }

        return DB::transaction(fn() =>
            $this->appointments->create([
                'user_id' => $user->id,
                'healthcare_professional_id' => $hcpId,
                'appointment_start_time' => $start,
                'appointment_end_time' => $end,
                'status' => Appointment::SATATUS_BOOKED,
            ])
        );
    }

    /**
     * Cancel Appointment
     *
     * @param mixed $user
     * @param Appointment $appointment
     *
     * @return Appointment
     */
    public function cancel($user, Appointment $appointment): Appointment
    {
        if ($appointment->user_id !== $user->id) {
            throw new BusinessException('You are not authorized to cancel this appointment.', 403);
        }

        if (now()->diffInHours($appointment->appointment_start_time, false) < 24) {
            throw new BusinessException('Cannot cancel within 24 hours of appointment start.');
        }

        $appointment->update(['status' => Appointment::SATATUS_CANCELLED]);
        return $appointment;
    }

    /**
     * Get Appointment by id
     *
     * @param int $id
     *
     * @return Appointment
     */
    public function getAppointment(int $id): Appointment
    {
        return $this->appointments->findById($id);
    }
}
