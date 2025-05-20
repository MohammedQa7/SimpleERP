<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('attachments', function (Blueprint $table) {
            $table->foreignId('folder_id')->after('attachment_id')->nullable()->constrained('folders')->cascadeOnDelete();
            $table->after('attachable_type', function ($table) {
                $table->string('name');
                $table->string('size');
                $table->string('type');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attachments', function (Blueprint $table) {
            //
        });
    }
};