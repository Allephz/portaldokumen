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
        Schema::create('file_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::table('department_files', function (Blueprint $table) {
            $table->foreignId('file_category_id')->nullable()->constrained('file_categories')->onDelete('set null')->after('department_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('department_files', function (Blueprint $table) {
            $table->dropForeign(['file_category_id']);
            $table->dropColumn('file_category_id');
        });

        Schema::dropIfExists('file_categories');
    }
};
