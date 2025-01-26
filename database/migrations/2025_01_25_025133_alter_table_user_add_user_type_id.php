<?php

use App\Models\User;
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
        $comment = 'User Types: 1 = Root, 2 = Admin, 3 = Employee';
        Schema::table('users', function (Blueprint $table) use ($comment) {
            $table->foreignId('user_type_id')->default(UserType::EMPLOYEE)->comment($comment)->constrained('user_type');
        });

        User::find(1)->update(['user_type_id' => UserType::ROOT]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_user_type_id_foreign');
            $table->dropColumn('user_type_id');
        });
    }
};
