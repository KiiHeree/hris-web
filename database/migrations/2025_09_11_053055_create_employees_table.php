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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            // relation
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('department_id')->nullable()->constrained();
            $table->foreignId('position_id')->nullable()->constrained();
            $table->foreignId('employment_status_id')->constrained();
            $table->foreignId('manager_id')->nullable()->constrained('employees');

            // identity
            $table->string('employee_code')->unique();
            $table->string('nik')->unique();

            // basic info
            $table->string('full_name');
            $table->enum('gender', ['L', 'P']);
            $table->date('birth_date');
            $table->string('birth_place')->nullable();

            // contact
            $table->text('address')->nullable();
            $table->string('telp')->nullable();
            $table->string('email')->nullable();

            // employment
            $table->date('join_date');
            $table->date('resign_date')->nullable();

            // finance
            $table->decimal('salary_basic', 12, 2)->default(0);
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('npwp')->nullable();

            // misc
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
