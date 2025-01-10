<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();

            $table->integer('role');

            $table->string('last_name');
            $table->string('first_name');
            $table->string('upei_id')->nullable();
            $table->string('email');
            $table->string('phone');

            $table->boolean('work_related');

            $table->datetime('happened_at');

            $table->string('location');

            $table->string('room_number')->nullable();

            $table->string('reported_to')->nullable();

            $table->jsonb('witnesses')->nullable();

            $table->integer('incident_type');
            $table->string('descriptor');

            $table->string('description');

            $table->string('injury_description')->nullable();

            $table->string('first_aid_description')->nullable();

            $table->string('reporters_email')->nullable();

            $table->string('supervisor_name')->nullable();

            $table->integer('status');

            $table->timestamp('closed_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
