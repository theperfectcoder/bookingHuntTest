<?php
declare(strict_types=1);

namespace Tests\Feature\Hunting;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Hunting\HuntingBooking;
use App\Models\Hunting\Guide;
use Tests\TestCase;

final class BookingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_cannot_double_book_guide_same_date(): void
    {
        $guide = Guide::query()->create([
            'name' => 'Рыбалка',
            'experience_years' => 6,
            'is_active' => true,
        ]);

        HuntingBooking::query()->create([
            'tour_name' => 'Охота на медведя',
            'hunter_name' => 'A',
            'guide_id' => $guide->id,
            'date' => '2025-11-05',
            'participants_count' => 2,
        ]);

        $payload = [
            'tour_name' => 'Охота на кролика',
            'hunter_name' => 'B',
            'guide_id' => $guide->id,
            'date' => '2025-11-05',
            'participants_count' => 3,
        ];

        $response = $this->postJson('/api/bookings', $payload);

        $response->assertStatus(409)
            ->assertJsonPath('message', 'Guide already booked for this date.');
    }

    public function test_guides_index_min_experience_filter(): void
    {
        Guide::query()->insert([
            ['name' => 'Junior', 'experience_years' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Senior', 'experience_years' => 7, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $res = $this->getJson('/api/guides?min_experience=5');

        $res->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Senior');
    }
}
