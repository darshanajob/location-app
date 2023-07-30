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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('name');
            $table->Integer('phone_number');
            $table->string('address');
            $table->string('profile_photo')->nullable();
            $table->timestamps();
           // $table->unsignedBigInteger('admin_id')->nullable();
           // $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

//       public function up(): void
// {
//     Schema::create('users', function (Blueprint $table) {
//         $table->id();
//         $table->string('name');
//         // Add other columns as needed
//         $table->timestamps();
//     });

//     Schema::create('customers', function (Blueprint $table) {
//         $table->id();
//         $table->foreignId('user_id')->constrained('users');
//         $table->string('phone_number');
//         $table->string('address');
//         $table->string('profile_photo')->nullable();
//         $table->timestamps();
//     });
// }


