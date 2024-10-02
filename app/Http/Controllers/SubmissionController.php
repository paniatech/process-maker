<?php

namespace App\Http\Controllers;

use App\Http\Requests\Submissions\SubmissionRequest;
use App\Http\Resources\FormResource;
use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use Inertia\Inertia;
use Inertia\Response;

class SubmissionController extends Controller
{
    public function index(Form $form): Response
    {
        return Inertia::render('Submissions/Submits', [
            'form' => new FormResource($form->load('submissions.payloads'))
        ]);
    }

    public function store(Form $form, SubmissionRequest $request): RedirectResponse
    {
        /** @var FormSubmission $submission */
        $submission = $form->submissions()->create();

        foreach ($request->all() as $payload)
            $submission->payloads()->attach($payload['field_id'], $payload);

        return redirect()->intended(route('landing', [
            'encrypt' => Crypt::encryptString($form->getAttribute('id'))
        ]));
    }
}
