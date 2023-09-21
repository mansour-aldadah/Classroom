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
        Schema::table('classrooms', function (Blueprint $table) {
            // $table->timestamp('deleted_at')->nullable();
            $table->softDeletes()->after('status');
            $table->enum('status', ['active', 'archived', 'deleted'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classrooms', function (Blueprint $table) {
            // $table->dropColumn('deleted_at');
            $table->dropSoftDeletes();
            $table->enum('status', ['active', 'archived'])->change();
        });
    }
};
