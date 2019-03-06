<?php

namespace App\Http\Controllers;

use App\School;
use Illuminate\Http\Request;

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

	public function create()
	{
		//
	}

	public function store(Request $request)
	{
		//
	}

	/**
	 * Displays the specified school if user is authenticated
	 *
	 * @param School $school
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function show(School $school)
	{
		if (auth()->user()->cannot('view', $school)) {
			return redirect('home')->with('alert.danger', 'You do not have access to this school');
		}
		$school = $this->school->find($school->id);

		return view('schools.show')->with('school', $school);
	}

	public function edit(School $school)
	{
		//
	}

	public function update(Request $request, School $school)
	{
		//
	}

	public function destroy(School $school)
	{
		//
	}
}
