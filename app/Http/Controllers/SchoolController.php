<?php

namespace App\Http\Controllers;

use App\Exceptions\UnauthorizedException;
use App\Http\Requests\StoreSchool;
use App\Http\Requests\UpdateSchool;
use App\School;

class SchoolController extends Controller
{
    protected $school;

    /**
     * SchoolController constructor.
     * @param School $school
     */
    public function __construct(School $school)
    {
        $this->school = $school;
    }

    /**
     * Displays a listing of schools for the authenticated user
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $schools = auth()->user()->schools()->get();

        return view('schools.index')->with('schools', $schools);
    }

    /**
     * Returns the form to create new schools
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws UnauthorizedException
     */
    public function create()
    {
        if (auth()->user()->cannot('create', $this->school)) {
            throw new UnauthorizedException();
        }

        return view('schools.create');
    }

    /**
     * Stores a newly created school in storage
     *
     * @param StoreSchool $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreSchool $request)
    {
        $school = $this->school->create($request->only('name'));
        auth()->user()->schools()->attach($school);

        return redirect()->route('schools.show', ['id' => $school->id])->with('alert.success', 'School created!');
    }

    /**
     * Displays the specified school if user is authenticated
     *
     * @param School $school
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws UnauthorizedException
     */
    public function show(School $school)
    {
        if (auth()->user()->cannot('view', $school)) {
            throw new UnauthorizedException();
        }
        $school = $this->school->find($school->id);

        return view('schools.show')->with('school', $school);
    }

    /**
     * Returns the form to update specified school
     *
     * @param School $school
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws UnauthorizedException
     */
    public function edit(School $school)
    {
        if (auth()->user()->cannot('update', $school)) {
            throw new UnauthorizedException();
        }
        $school = $this->school->find($school->id);

        return view('schools.edit')->with('school', $school);
    }

    /**
     * Updates the specified school in storage
     *
     * @param UpdateSchool $request
     * @param School $school
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateSchool $request, School $school)
    {
        $school->update($request->only('name'));

        return redirect()->route('schools.show', ['id' => $school->id])->with('alert.success', 'School updated!');
    }

    /**
     * Removes the specified school from storage
     *
     * @param School $school
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws UnauthorizedException
     */
    public function destroy(School $school)
    {
        if (auth()->user()->cannot('delete', $school)) {
            throw new UnauthorizedException();
        }
        $this->school->destroy($school->id);

        return redirect()->route('schools.index')->with('alert.success', 'School deleted!');
    }
}
