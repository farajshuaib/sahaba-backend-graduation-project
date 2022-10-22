<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'reported_by' => UserResource::make($this->whenLoaded('user')),
            'type' => $this->type,
            'message' => $this->message,
            'created_at' => $this->created_at,
            'reportable_type' => $this->reportable_type,
        ];
    }
}
