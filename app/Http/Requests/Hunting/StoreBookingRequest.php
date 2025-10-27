<?php
declare(strict_types=1);

namespace App\Http\Requests\Hunting;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Валидация входных данных для создания бронирования.
 */
final class StoreBookingRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'tour_name' => ['required', 'string', 'max:255'],
            'hunter_name' => ['required', 'string', 'max:255'],
            'guide_id' => ['required', 'integer', 'exists:guides,id'],
            'date' => ['required', 'date_format:Y-m-d'],
            'participants_count' => ['required', 'integer', 'between:1,10'],
        ];
    }
}
