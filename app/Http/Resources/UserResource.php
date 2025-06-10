<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'jobTitle' => $this->job_title,
            'phoneNumber' => $this->phone_number,
            'accountCode' => $this->account_code,
            'profilePhotoUrl' => $this->profile_photo_url,
            'address' => $this->address,
            'salary' => $this->salary,
            'roles' => RoleResource::collection($this->roles),
        ];
    }
}