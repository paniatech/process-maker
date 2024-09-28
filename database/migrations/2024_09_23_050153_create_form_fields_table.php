<?php

use App\Models\Form;
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
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Form::class)->constrained('forms')->cascadeOnDelete();

            $table->string('label');
            $table->string('name');

            // #TODO: Convert this column to enum
            $table->string('type');  // text, textarea, select, radio, checkbox, etc.

            $table->text('options')->nullable(); // Options for fields like select, checkbox

            $table->boolean('is_required')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_fields');
    }
};
