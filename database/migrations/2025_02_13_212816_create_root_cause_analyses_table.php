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
        Schema::create('root_cause_analyses', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignId('supervisor_id')->constrained('users');
            $table->foreignUuid('incident_id')->constrained('incidents');

            $table->jsonb('individuals_involved')->nullable();

            $table->text('primary_effect')->nullable();

            $table->jsonb('whys')->nullable();

            // effective_solutions and corrective_actions were combined
            $table->jsonb('solutions_and_actions')->nullable();

            $table->jsonb('peoples_positions')->nullable();
            $table->jsonb('attention_to_work')->nullable();
            $table->jsonb('communication')->nullable();

            // Using PPE
            $table->boolean('ppe_in_good_condition')->nullable();
            $table->boolean('ppe_in_use')->nullable();
            $table->boolean('ppe_correct_type')->nullable();

            // Execution of Work
            $table->boolean('correct_tool_used')->nullable();
            $table->boolean('policies_followed')->nullable();
            $table->boolean('worked_safely')->nullable();
            $table->boolean('used_tool_properly')->nullable();
            $table->boolean('tool_in_good_condition')->nullable();

            $table->jsonb('working_conditions')->nullable();
            $table->jsonb('root_causes')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('root_cause_analyses');
    }
};
