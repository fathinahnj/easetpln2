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
        Schema::table('multiple_tables', function (Blueprint $table) {
            if (Schema::hasColumn('barangs', 'no')) {
                Schema::table('barangs', function (Blueprint $table) {
                    $table->dropColumn('no');
                });
            }

            if (Schema::hasColumn('ruangans', 'no')) {
                Schema::table('ruangans', function (Blueprint $table) {
                    $table->dropColumn('no');
                });
            }

            if (Schema::hasColumn('history_laporans', 'no')) {
                Schema::table('history_laporans', function (Blueprint $table) {
                    $table->dropColumn('no');
                });
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('multiple_tables', function (Blueprint $table) {
            Schema::table('barangs', function (Blueprint $table) {
                $table->integer('no')->nullable();
            });

            Schema::table('ruangans', function (Blueprint $table) {
                $table->integer('no')->nullable();
            });

            Schema::table('history_laporans', function (Blueprint $table) {
                $table->integer('no')->nullable();
            });
        });
    }
};
