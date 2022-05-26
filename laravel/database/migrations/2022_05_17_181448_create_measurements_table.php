<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('session_id')->constrained('sessions')->onDelete('cascade');
            $table->enum('hand_view', ['thumb_side', 'pink_side', 'finger_side', 'back_side']);
            $table->enum('hand_type', ['left', 'right']);
            $table->float('hand_score');
            $table->json('finger_thumb');
            $table->json('finger_index');
            $table->json('finger_middle');
            $table->json('finger_ring');
            $table->json('finger_5');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('measurements');
    }
};
