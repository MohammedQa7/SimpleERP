<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        !$request->routeIs(route('events.calendar'))
            ? $this->start_date = Carbon::parse($this->start_date)
            : '';

        $this->starts_at = Carbon::parse($this->starts_at)->format('h:i A');
        $this->ends_at = Carbon::parse($this->ends_at)->format('h:i A');

        return [
            'id' => $this->id,
            'user' => new UserResource($this->whenLoaded('user')),
            'invitedUsers' => UserResource::collection($this->whenLoaded('invitedUsers')),
            'title' => $this->title,
            'description' => $this->description,
            'startDate' => $this->formatStartDateIfRoute(),
            'startsAt' => $this->starts_at,
            'endsAt' => $this->ends_at,
            'status' => $this->status,
            'priority' => $this->priority,
        ];
    }


    function formatStartDateIfRoute(string $route = 'events.calendar')
    {
        return request()->routeIs($route)
            ? $this->start_date
            : [
                'day' => $this->start_date->format('d'),
                'month' => $this->start_date->format('M'),
                'fullDate' => $this->start_date->format('d/M/Y')
            ];
    }
}