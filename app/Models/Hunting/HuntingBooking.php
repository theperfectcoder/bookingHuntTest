<?php
declare(strict_types=1);

namespace App\Models\Hunting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $tour_name
 * @property string $hunter_name
 * @property int $guide_id
 * @property Carbon $date
 * @property int $participants_count
 */
final class HuntingBooking extends Model
{
    use HasFactory;

    /** @var string[] */
    protected $fillable = [
        'participants_count',
        'hunter_name',
        'tour_name',
        'guide_id',
        'date'
    ];

    /** @var array<string, string> */
    protected $casts = [
        'participants_count' => 'integer',
        'guide_id' => 'integer',
        'date' => 'date',
    ];

    /**
     * @return BelongsTo<Guide, self>
     */
    public function guide(): BelongsTo
    {
        return $this->belongsTo(Guide::class);
    }
}
