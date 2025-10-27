<?php
declare(strict_types=1);

namespace App\Http\Resources\Hunting;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Hunting\Guide;
use Illuminate\Http\Request;

/** @mixin Guide */
final class GuideResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'experience_years' => $this->experience_years,
        ];
    }
}
