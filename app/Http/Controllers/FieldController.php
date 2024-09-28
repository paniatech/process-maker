<?php

namespace App\Http\Controllers;

use App\Http\Requests\Fields\FiledRequest;
use App\Http\Resources\FormResource;
use App\Models\Form;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class FieldController extends Controller
{
    public function index(Form $form): Response
    {
        return Inertia::render('Fields/modal', [
            'form' => new FormResource($form->load('fields'))
        ]);
    }

    public function store(Form $form, FiledRequest $request): RedirectResponse
    {
        $form->fields()->delete();

        $form->fields()->createMany($request->validated('fields'));

        return redirect()->intended(route('forms.fields.index', ['form' => $form->getAttribute('id')]));
    }
}
