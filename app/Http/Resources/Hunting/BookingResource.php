<?php
declare(strict_types=1);

namespace App\Http\Resources\Hunting;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Hunting\HuntingBooking;
use Illuminate\Http\Request;

/** @mixin HuntingBooking */
final class BookingResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tour_name' => $this->tour_name,
            'hunter_name' => $this->hunter_name,
            'date' => $this->date->toDateString(),
            'participants_count' => $this->participants_count,
            'guide' => [
                'id' => $this->guide->id,
                'name' => $this->guide->name,
                'experience_years' => $this->guide->experience_years,
            ],
        ];
    }
}
