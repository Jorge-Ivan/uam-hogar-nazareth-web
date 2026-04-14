<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('donation_nequi')->nullable()->after('donation_nit_bank');
            $table->string('donation_daviplata')->nullable()->after('donation_nequi');
            $table->foreignId('donation_qr_media_id')->nullable()->after('donation_daviplata')
                  ->constrained('media')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropForeign(['donation_qr_media_id']);
            $table->dropColumn(['donation_nequi', 'donation_daviplata', 'donation_qr_media_id']);
        });
    }
};
