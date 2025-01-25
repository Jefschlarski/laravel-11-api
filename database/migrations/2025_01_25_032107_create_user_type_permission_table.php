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
        Schema::create('user_type_permission', function (Blueprint $table) {
            $table->foreignId('permission_id')->constrained('permission');
            $table->foreignId('user_type_id')->constrained('user_type');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->primary(['permission_id', 'user_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_type_permission');
    }
};
