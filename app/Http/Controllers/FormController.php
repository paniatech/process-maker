<?php

namespace App\Http\Controllers;

use App\Http\Requests\Forms\FormRequest;
use App\Http\Resources\FormCollection;
use App\Http\Resources\FormResource;
use App\Models\Form;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class FormController extends Controller
{
    public function index(): Response
    {
        /** @var User $user */
        $user = Auth::user();

        return Inertia::render('Forms/Form', [
            'forms' => new FormCollection($user->forms()->paginate())
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Forms/Create');
    }

    public function store(FormRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $form = $user->forms()->create($request->validated());

        return redirect()->intended(route('forms.edit',['form' => $form->getAttribute('id')]));
    }

    public function edit(Form $form): Response
    {
        return Inertia::render('Forms/Edit', [
            'form' => new FormResource($form)
        ]);
    }
}
