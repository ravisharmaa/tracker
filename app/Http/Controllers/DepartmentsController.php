<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Support\Facades\Gate;

class DepartmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        abort_if(Gate::denies('create-department'), 401);

        Department::create(\request()->all());

        return back();
    }
}
