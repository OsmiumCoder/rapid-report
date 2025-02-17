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

            $table->foreignUuid('incident_id')->constrained('incidents');
            $table->foreignId('supervisor_id')->constrained('users');

            $table->jsonb('individuals_involved');

            $table->text('primary_effect');

            $table->jsonb('effective_solutions');
            $table->jsonb('corrective_actions');

            $table->jsonb('peoples_positions');
            $table->jsonb('attention_to_work');
            $table->jsonb('communication');

            // Using PPE
            $table->boolean('ppe_in_good_condition');
            $table->boolean('ppe_in_use');
            $table->boolean('ppe_correct_type');

            // Execution of Work
            $table->boolean('correct_tool_used');
            $table->boolean('policies_followed');
            $table->boolean('worked_safely');
            $table->boolean('used_tool_properly');
            $table->boolean('tool_in_good_condition');

            $table->jsonb('working_conditions');
            $table->jsonb('root_causes');

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
