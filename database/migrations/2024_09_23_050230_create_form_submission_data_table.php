<?php

use App\Models\FormField;
use App\Models\FormSubmission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('form_submission_data', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(FormSubmission::class)->constrained('form_submissions')->onDelete('cascade');

            $table->foreignIdFor(FormField::class)->constrained('form_fields')->onDelete('cascade');

            $table->text('field_value');  // Stores the value submitted by the user

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_submission_data');
    }
};
