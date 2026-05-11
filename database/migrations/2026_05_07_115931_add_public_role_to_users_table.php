<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify ENUM column to include 'public'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'petugas', 'public') DEFAULT 'petugas'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original ENUM (Warning: this will fail if there are 'public' users)
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'petugas') DEFAULT 'petugas'");
    }
};
