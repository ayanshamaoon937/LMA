<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adds a JSON column for structured per-section data that doesn't fit
     * the existing title/subtitle/content/image/button_* columns — e.g.
     * the repeatable list of icon/title/description items inside the
     * "Our Sectors" section.
     */
    public function up(): void
    {
        Schema::table('page_sections', function (Blueprint $table) {
            $table->json('meta')->nullable()->after('button_link');
        });
    }

    public function down(): void
    {
        Schema::table('page_sections', function (Blueprint $table) {
            $table->dropColumn('meta');
        });
    }
};
