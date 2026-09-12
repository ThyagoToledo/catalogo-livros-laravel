<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('normalized_title')->default('');
            $table->string('normalized_author')->default('');
        });

        DB::table('books')
            ->orderBy('id')
            ->each(function (object $book): void {
                DB::table('books')
                    ->where('id', $book->id)
                    ->update([
                        'normalized_title' => Str::lower(trim($book->title)),
                        'normalized_author' => Str::lower(trim($book->author)),
                    ]);
            });

        Schema::table('books', function (Blueprint $table) {
            $table->unique(['normalized_title', 'normalized_author']);
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropUnique(['normalized_title', 'normalized_author']);
            $table->dropColumn(['normalized_title', 'normalized_author']);
        });
    }
};
