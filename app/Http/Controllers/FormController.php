<?php

namespace App\Http\Controllers;

use App\Helpers\Response\FormatResponse;
use App\Http\Resources\FormCollection;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    public function index(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        return FormatResponse::success(new FormCollection($user->forms()->paginate()));
    }
}
