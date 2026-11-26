<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // table() modifies "comments" table which was created in another migration file
        Schema::table('comments', function (Blueprint $table) {
            // nullable() -->  when someone submits a new comment, it has not been approved yet
            $table->timestamp('approved_at')->nullable();
        });
    }
};

// create() creates a new table
// table() modifies and existing table
//   - this adds a new column "approved_at" to existing "comments" table
