<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('category');

            $table->foreignId('category')
                ->nullable()
                ->constrained('categories');
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropForeign(['category']);
            $table->dropColumn('category');

            $table->string('category');
        });
    }
};
