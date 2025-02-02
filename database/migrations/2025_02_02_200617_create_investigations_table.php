<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('investigations', function (Blueprint $table) {
            $table->id();

            $table->foreignUuid('incident_id');

            $table->string('title');
            $table->text('description');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('investigations');
    }
};
