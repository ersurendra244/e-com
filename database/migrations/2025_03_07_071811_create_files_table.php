<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{

    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('uploadfile');
            $table->text('remark')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->enum('is_delete', ['0', '1'])->default('0')->comment('1=Delete, 0=Not Delete');
            $table->enum('status', ['0', '1'])->default('1')->comment('1=Active, 0=Inactive');
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
        Schema::dropIfExists('files');
    }
}
