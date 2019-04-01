<?php

namespace App\Http\Controllers;

use App\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Gate;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws UnauthorizedException
     */
    public function index()
    {
        if (Gate::denies('view-settings', auth()->user())) {
            throw new UnauthorizedException();
        }

        return view('settings');
    }
}
