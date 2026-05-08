<?php
declare(strict_types=1);

namespace App\Models\Hunting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int $experience_years
 * @property bool $is_active
 */
final class Guide extends Model
{
    use HasFactory;

    /** @var string[] */
    protected $fillable = [
        'name',
        'experience_years',
        'is_active'
    ];

    /** @var array<string, string> */
    protected $casts = [
        'experience_years' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * @return HasMany<HuntingBooking>
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(HuntingBooking::class);
    }
}
