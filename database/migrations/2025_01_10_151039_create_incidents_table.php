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
            $table->uuid('id');

            $table->boolean('anonymous');
            $table->boolean('on_behalf');
            $table->boolean('on_behalf_anonymous');

            $table->integer('role');

            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('upei_id')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            $table->boolean('work_related');

            $table->datetime('happened_at');

            $table->string('location');

            $table->string('room_number')->nullable();

            $table->jsonb('witnesses')->nullable();

            $table->integer('incident_type');
            $table->string('descriptor');

            $table->string('description');

            $table->string('injury_description')->nullable();

            $table->string('first_aid_description')->nullable();

            $table->string('reporters_email')->nullable();
            $table->index('reporters_email');

            // A string that will contain the supervisor that was given in the form
            $table->string('supervisor_name')->nullable();

            // The currently assigned supervisor
            $table->foreignId('supervisor_id')->nullable()->constrained('users');

            $table->string('status');

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
