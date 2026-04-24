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
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('terms_accepted_at')->nullable()->after('password');
            $table->timestamp('privacy_policy_accepted_at')->nullable()->after('terms_accepted_at');
            $table->timestamp('data_processing_accepted_at')->nullable()->after('privacy_policy_accepted_at');
            $table->string('data_processing_consent_version', 20)->nullable()->after('data_processing_accepted_at');
            $table->string('data_processing_accepted_ip', 45)->nullable()->after('data_processing_consent_version');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'terms_accepted_at',
                'privacy_policy_accepted_at',
                'data_processing_accepted_at',
                'data_processing_consent_version',
                'data_processing_accepted_ip',
            ]);
        });
    }
};
