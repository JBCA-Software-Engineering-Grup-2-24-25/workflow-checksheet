<?php

namespace App\Http\Resources\Iam;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

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
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'role'          => !empty($this->role->name) ? $this->role->name : '-',
            'is_online'     => Cache::has(config('auth.user_online') . $this->id) ? true : false,
            'last_seen'     => !empty($this->last_seen) ? Carbon::parse($this->last_seen)->diffForHumans() : '-',
            'email_verified' => !empty($this->email_verified_at) ? 'Verified' : 'Not Verified',
            'created_at'    => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at'    => !empty($this->updated_at) ? $this->updated_at->format('Y-m-d H:i:s') : null,
        ];
    }
}
