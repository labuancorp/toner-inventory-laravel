<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('pref_order_emails_enabled')->default(true)->after('role');
            $table->string('pref_email_format')->default('html')->after('pref_order_emails_enabled');
            $table->string('pref_notification_frequency')->default('immediate')->after('pref_email_format');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['pref_order_emails_enabled', 'pref_email_format', 'pref_notification_frequency']);
        });
    }
};