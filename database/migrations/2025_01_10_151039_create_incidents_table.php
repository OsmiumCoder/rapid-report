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
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('supervisor_id')->nullable();
            $table->boolean('work_related')->default(false);
            $table->datetime('incident_date');
            $table->string('location');
            $table->string('room_number')->nullable();
            $table->string('reported_to')->nullable();
            $table->string('incident_type');
            $table->string('descriptor');
            $table->string('description');
            $table->boolean('has_injury')->default(false);
            $table->string('first_aid_description')->nullable();
            $table->integer('status')->default(0);
            $table->date('closed_at')->nullable();
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
