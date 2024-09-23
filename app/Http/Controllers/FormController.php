<?php

namespace App\Http\Controllers;

use App\Http\Resources\FormCollection;
use App\Models\User;
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
}
