<?php
declare(strict_types=1);

namespace App\Actions\Hunting;

use App\Models\Hunting\HuntingBooking;
use Illuminate\Support\Facades\DB;
use App\Models\Hunting\Guide;
use Throwable;

/**
 * Бизнес-юнит-кейс: создание бронирования охоты.
 * Валидация входа выполняется в FormRequest, здесь доменные инварианты.
 */
final class CreateBookingAction
{
    /**
     * @param array{
     *     tour_name: string,
     *     hunter_name: string,
     *     guide_id: int,
     *     date: string,
     *     participants_count: int
     * } $data
     * @throws \RuntimeException
     */
    public function execute(array $data): HuntingBooking
    {
        /** @var Guide|null $guide */
        $guide = Guide::find($data['guide_id']);
        if ($guide === null) {
            throw new \RuntimeException('Guide not found.');
        }
        if ($guide->is_active === false) {
            throw new \RuntimeException('Guide is not active.');
        }

        // Логическая проверка занятости (дублируется уникальным индексом в БД)
        $exists = HuntingBooking::query()
            ->where('guide_id', $guide->id)
            ->whereDate('date', $data['date'])
            ->exists();
        if ($exists) {
            throw new \RuntimeException('Guide already booked for this date.');
        }

        try {
            /** @var HuntingBooking $booking */
            $booking = DB::transaction(static fn (): HuntingBooking => HuntingBooking::create($data), 3);
            return $booking;
        } catch (Throwable $e) {
            // Скрываем детали ошибок слоя хранения
            throw new \RuntimeException('Failed to create booking.');
        }
    }
}
