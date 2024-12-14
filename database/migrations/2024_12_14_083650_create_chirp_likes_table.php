<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chirp_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chirp_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['chirp_id', 'user_id']); // Empêche un utilisateur de liker deux fois le même chirp
        });
    }

    public function down()
    {
        Schema::dropIfExists('chirp_likes');
    }
};
