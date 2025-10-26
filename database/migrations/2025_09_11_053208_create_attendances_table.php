<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('users')->onDelete('cascade');
            $table->date('date');
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->enum('status', ['hadir', 'izin', 'sakit', 'cuti', 'lembur', 'alpha','telat','libur'])->default('hadir');
            $table->decimal('overtime_hours', 5, 2)->default(0); // total jam lembur
            $table->boolean('is_holiday')->default(false); // kalau sabtu/minggu/libur nasional
            $table->string('source')->nullable(); // QR/manual/import
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
