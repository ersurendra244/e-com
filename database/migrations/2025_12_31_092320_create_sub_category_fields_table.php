<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCategoryFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_category_fields', function (Blueprint $table) {
            $table->id();
            $table->integer('field_id');
            $table->unsignedBigInteger('subcategory_id');
            $table->string('row_class', 191)->default('6');
            $table->string('field_class', 191)->nullable();
            $table->boolean('is_required')->default(false);
            $table->integer('order')->default(null);
            $table->enum('is_delete', ['0', '1'])->default('0')->comment('1=Delete, 0=Not Delete');
            $table->enum('status', ['0', '1'])->default('1')->comment('1=Active, 0=Inactive');
            $table->timestamps();

            $table->foreign('subcategory_id')
                ->references('id')->on('categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_category_fields');
    }
}
