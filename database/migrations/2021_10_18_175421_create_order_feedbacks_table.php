<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_feedbacks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('feedback')->nullable();
            $table->enum('read',[0,1])->default(0);
            $table->foreignId('user_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_feedbacks');
    }
}
