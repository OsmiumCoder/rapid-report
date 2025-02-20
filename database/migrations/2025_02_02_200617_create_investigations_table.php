<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('investigations', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('incident_id')->constrained('incidents');
            $table->foreignId('supervisor_id')->constrained('users');

            $table->text('immediate_causes');
            $table->text('basic_causes');
            $table->text('remedial_actions');
            $table->text('prevention');

            $table->char('hazard_class');
            $table->integer('risk_rank');

            $table->jsonb('resulted_in');

            $table->jsonb('substandard_acts')->nullable();
            $table->jsonb('substandard_conditions')->nullable();
            $table->jsonb('energy_transfer_causes')->nullable();
            $table->jsonb('personal_factors')->nullable();
            $table->jsonb('job_factors')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('investigations');
    }
};
