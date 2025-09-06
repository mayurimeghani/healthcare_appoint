<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\AppointmentService;
use App\Exceptions\BusinessException;
use App\Http\Resources\AppointmentResource;
use App\Repositories\AppointmentRepository;
use App\Http\Requests\BookAppointmentRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AppointmentController extends Controller
{
    public function __construct(
        private AppointmentService $service,
        private AppointmentRepository $appointments
    ) {}

    /**
     * Get appointments
     *
     * @param Request $request
     *
     * @return [type]
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $appointments = $this->appointments->forUser($request->user()->id);

        return AppointmentResource::collection($appointments);
    }

    /**
     * Store appointment
     *
     * @param BookAppointmentRequest $request
     *
     * @return AppointmentResource
     */
    public function store(BookAppointmentRequest $request): AppointmentResource
    {
        $appointment = $this->service->book(
            $request->user(),
            $request->healthcare_professional_id,
            $request->appointment_start_time,
            $request->appointment_end_time,
        );

        return new AppointmentResource($appointment);
    }

    /**
     * Cancel appointment
     *
     * @param mixed $id
     * @param Request $request
     *
     * @return AppointmentResource|json
     */
    public function cancel($id, Request $request)
    {
        $appointment = $this->appointments->findById($id);
        if (! $appointment) {
            throw new BusinessException(trans('error_message.appointmet_not_found'));
        }

        $updated = $this->service->cancel($request->user(), $appointment);

        return new AppointmentResource($updated);
    }

    /**
     * Show appointment
     *
     * @param int $id
     *
     * @return AppointmentResource
     */
    public function show(int $id): AppointmentResource
    {
        $appointment = $this->service->getAppointment($id);

        if (!$appointment) {
            return throw new BusinessException(trans('error_message.appointmet_not_found'));
        }

        return new AppointmentResource($appointment);
    }
}
