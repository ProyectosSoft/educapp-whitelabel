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
        if (Schema::hasColumn('evaluations', 'wait_time_hours') && !Schema::hasColumn('evaluations', 'wait_time_minutes')) {
            Schema::table('evaluations', function (Blueprint $table) {
                $table->renameColumn('wait_time_hours', 'wait_time_minutes');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('evaluations', 'wait_time_minutes') && !Schema::hasColumn('evaluations', 'wait_time_hours')) {
            Schema::table('evaluations', function (Blueprint $table) {
                $table->renameColumn('wait_time_minutes', 'wait_time_hours');
            });
        }
    }
};
