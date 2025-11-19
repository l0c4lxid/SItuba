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
        if (! Schema::hasTable('family_members')) {
            return;
        }

        Schema::table('family_members', function (Blueprint $table) {
            if (! Schema::hasColumn('family_members', 'nik')) {
                $table->string('nik', 30)->nullable()->after('relation');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('family_members')) {
            return;
        }

        Schema::table('family_members', function (Blueprint $table) {
            if (Schema::hasColumn('family_members', 'nik')) {
                $table->dropColumn('nik');
            }
        });
    }
};
