<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add the new plain-text year column
        Schema::table('documents', function (Blueprint $table) {
            $table->string('year', 4)->nullable()->after('document_category_id');
        });

        // Drop FK constraint and column — cross-database compatible
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            // SQLite cannot drop a column referenced in a FK definition.
            // The only safe approach is to recreate the table without that column.
            DB::statement('PRAGMA foreign_keys = OFF');
            DB::statement('
                CREATE TABLE documents_new (
                    id         INTEGER      PRIMARY KEY AUTOINCREMENT,
                    title      VARCHAR(255) NOT NULL,
                    description TEXT        NULL,
                    document_category_id INTEGER NOT NULL,
                    year       VARCHAR(4)   NULL,
                    media_id   INTEGER      NOT NULL,
                    created_at TIMESTAMP    NULL,
                    updated_at TIMESTAMP    NULL
                )
            ');
            DB::statement('
                INSERT INTO documents_new
                    (id, title, description, document_category_id, year, media_id, created_at, updated_at)
                SELECT
                    id, title, description, document_category_id, year, media_id, created_at, updated_at
                FROM documents
            ');
            DB::statement('DROP TABLE documents');
            DB::statement('ALTER TABLE documents_new RENAME TO documents');
            DB::statement('PRAGMA foreign_keys = ON');
        } else {
            Schema::table('documents', function (Blueprint $table) {
                $table->dropForeign(['document_year_id']);
                $table->dropColumn('document_year_id');
            });
        }
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->unsignedBigInteger('document_year_id')->nullable()->after('document_category_id');
            $table->foreign('document_year_id')->references('id')->on('document_years')->nullOnDelete();
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('year');
        });
    }
};
