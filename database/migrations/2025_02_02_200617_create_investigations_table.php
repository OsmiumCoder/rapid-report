<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('investigations', function (Blueprint $table) {
            $table->id();

            $table->foreignUuid('incident_id');

            $table->text('immediate_causes');
            $table->text('basic_causes');
            $table->text('remedial_actions');
            $table->text('prevention');

            $table->char('hazard_class');
            $table->integer('risk_rank');

            $table->jsonb('resulted_in');


            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('investigations');
    }
};
