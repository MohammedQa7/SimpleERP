<?php

use App\Enums\Priorities;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('department_notificaions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('from_department');
            $table->string('to_department');
            $table->text('data');
            $table->string('priority')->default(Priorities::NORMAL->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_notificaions');
    }
};