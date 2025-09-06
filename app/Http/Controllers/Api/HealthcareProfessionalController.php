<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\HealthcareProfessionalService;
use App\Http\Resources\HealthcareProfessionalResource;
use Illuminate\Http\JsonResponse;

class HealthcareProfessionalController extends Controller
{
    public function __construct(private HealthcareProfessionalService $hcpService) {}

    /**
     * All health professionals
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $professionals = $this->hcpService->getAllPaginated();

        return response()->json(HealthcareProfessionalResource::collection($professionals));
    }

    /**
     * Show health professional
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $hcp = $this->hcpService->getById($id);

        if (! $hcp) {
            return response()->json(['message' => trans('error_message.professional_not_found')]);
        }

        return response()->json(new HealthcareProfessionalResource($hcp));
    }
}
