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
        Schema::table('pages', function (Blueprint $table) {
            $table->foreignId('parent_id')
                ->nullable()
                ->after('id')
                ->constrained('pages')
                ->nullOnDelete();

            $table->boolean('show_in_header')->default(false)->after('published_at');
            $table->boolean('show_in_footer')->default(false)->after('show_in_header');
            $table->smallInteger('menu_order')->unsigned()->default(0)->after('show_in_footer');

            $table->index(['show_in_header', 'status'], 'pages_header_status_index');
            $table->index(['show_in_footer', 'status'], 'pages_footer_status_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropIndex('pages_header_status_index');
            $table->dropIndex('pages_footer_status_index');
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['parent_id', 'show_in_header', 'show_in_footer', 'menu_order']);
        });
    }
};
