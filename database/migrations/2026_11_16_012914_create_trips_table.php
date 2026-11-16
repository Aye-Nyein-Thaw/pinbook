<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id');
            $table->string('title');
            $table->text('description');
            $table->string('destination');
            $table->date('start_date');
            $table->date('end_date')->nullable(); // can be empty
            $table->boolean('is_public');

            $table->timestamps();
        });
    }
};
