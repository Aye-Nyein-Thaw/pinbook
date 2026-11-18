<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_place', function (Blueprint $table) {
            $table->foreignId('category_id');
            $table->foreignId('place_id');
        });
    }
};
