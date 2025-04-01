<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_group_id')->nullable(); // إضافة العمود
            $table->foreignId('client_id')->constrained()->onDelete('cascade'); // ارتباط مع جدول العملاء
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // ارتباط مع جدول المنتجات
            $table->date('order_date');
            $table->decimal('total_price', 10, 2);
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
