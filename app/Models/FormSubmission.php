<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FormSubmission extends Model
{
    use HasFactory;

    public function payloads(): BelongsToMany
    {
        return $this->belongsToMany(FormField::class, 'form_submission_data', 'submission_id','field_id')
            ->withPivot('field_value')->withTimestamps();
    }


}
