<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('user_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 40);
            $table->longText('category_photo')->nullable();
            $table->foreignIdFor(\App\Models\User::class)->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_categories');
    }
}
