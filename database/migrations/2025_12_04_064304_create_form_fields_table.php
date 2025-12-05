<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subcategory_id');
            $table->string('field_label');                 // Display name like "Color", "Size"
            $table->string('field_name');                  // Internal name like "color", "size"
            $table->enum('field_type', ['text', 'textarea', 'select', 'checkbox', 'radio', 'number', 'date']);
            $table->json('field_options')->nullable();     // For select/checkbox/radio
            $table->boolean('is_required')->default(false);
            $table->integer('order_no')->default(0);
            $table->timestamps();

            // Foreign Key (optional, if you have subcategories table)
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
        Schema::dropIfExists('form_fields');
    }
}
