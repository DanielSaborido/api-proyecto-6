<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignIdFor(\App\Models\User::class)->constrained();
            $table->foreignIdFor(\App\Models\Category::class)->nullable()->constrained();
            $table->foreignIdFor(\App\Models\UserCategory::class)->nullable()->constrained();
            $table->text('description');
            $table->dateTime('creation_date')->default(now());
            $table->dateTime('update_date')->default(now());
            $table->dateTime('due_date')->nullable();
            $table->enum('status', ['complete', 'processing', 'pending'])->default('pending');
            $table->boolean('priority')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
