<?php

use App\Models\UserType;
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
        $userTypes = [
            ['name' => 'Root', 'description' => 'Root User Type', 'created_by' => 1],
            ['name' => 'Admin', 'description' => 'Admin User Type', 'created_by' => 1],
            ['name' => 'Employee', 'description' => 'User User Type', 'created_by' => 1],
        ];

        Schema::create('user_type', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->text('description')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
        });

        foreach ($userTypes as $userType) {
            UserType::create($userType);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_type');
    }
};
