<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryIdToTodosTable extends Migration
{
    public function up()
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null'); // Menambahkan category_id dengan foreign key
        });
    }

    public function down()
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }
}