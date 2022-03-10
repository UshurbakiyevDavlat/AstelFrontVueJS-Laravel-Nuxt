<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Vacancy;
use App\Models\Callback;

class FormController extends Controller
{

    public function callback(Request $request)
    {
        return Callback::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'message' => $request->message,
            'city' => $request->city,
            'is_partnership' => $request->partners ?? false,
            'service_id' => $request->service_id ?? null
        ]);
    }

    public function vacancy(Request $request, Vacancy $vacancy)
    {
        return $vacancy->jobApplications()->create([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'message' => $request->message,
            'cv' => $request->hasFile('cv') ? 'elfinder/' . \Storage::disk('elfinder')->put('cvs', $request->file('cv')) : null,
        ]);
    }

}
