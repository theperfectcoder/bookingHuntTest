<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('hunting_bookings', static function (Blueprint $table): void {
            $table->id();
            $table->string('tour_name');
            $table->string('hunter_name');
            $table->foreignId('guide_id')->constrained('guides')->cascadeOnUpdate()->restrictOnDelete();
            $table->date('date');
            $table->unsignedTinyInteger('participants_count');
            $table->timestamps();

            // Инвариант: у гида только одно бронирование на дату
            $table->unique(['guide_id', 'date']);
            $table->index(['date', 'guide_id']);
        });
    }

    /**
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('hunting_bookings');
    }
};
