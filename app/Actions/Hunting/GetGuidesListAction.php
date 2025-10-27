<?php
declare(strict_types=1);

namespace App\Actions\Hunting;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Hunting\Guide;

/**
 * Юзкейс: получение списка активных гидов с опциональным фильтром по стажу.
 */
final class GetGuidesListAction
{
    /**
     * @param int|null $minExperience Минимальный стаж, если задан
     * @return Collection<int, Guide>
     */
    public function execute(?int $minExperience = null): Collection
    {
        $query = Guide::query()->where('is_active', true);

        if ($minExperience !== null && $minExperience > 0) {
            $query->where('experience_years', '>=', $minExperience);
        }

        return $query->orderByDesc('experience_years')->get();
    }
}
