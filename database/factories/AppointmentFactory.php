<?php

namespace Database\Factories;

use App\Models\Appointment;
use Carbon\Carbon;
use App\Models\User;
use App\Models\HealthcareProfessional;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = Carbon::now()->addDays(rand(1, 10))->setTime(rand(9, 16), 0);
        $endTime   = (clone $startTime)->addHour();
        $statuses = [Appointment::SATATUS_BOOKED, Appointment::SATATUS_COMPLETED, Appointment::SATATUS_CANCELLED];
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'healthcare_professional_id' => HealthcareProfessional::inRandomOrder()->first()->id ?? HealthcareProfessional::factory(),
            'appointment_start_time' => $startTime,
            'appointment_end_time'   => $endTime,
            'status' => $this->faker->randomElement($statuses),
        ];
    }
}
