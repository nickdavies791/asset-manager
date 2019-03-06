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

	/**
	 * Stores a newly created school in storage
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store(Request $request)
	{
		if (auth()->user()->cannot('create', $this->school)) {
			return redirect('home')->with('alert.danger', 'You do not have access to create schools');
		}
		$school = $this->school->create([
			'name' => $request->name
		]);
		auth()->user()->schools()->attach($school);

		return redirect()->route('schools.show', ['id' => $school->id])->with('alert.success', 'School created!');
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

	/**
	 * Updates the specified school in storage
	 *
	 * @param Request $request
	 * @param School $school
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function update(Request $request, School $school)
	{
		if (auth()->user()->cannot('update', $school)) {
			return redirect('home')->with('alert.danger', 'You do not have access to update schools');
		}
		$school->name = $request->name;
		$school->save();

		return redirect()->route('schools.show', ['id' => $school->id])->with('alert.success', 'School updated!');
	}

	/**
	 * Removes the specified school from storage
	 *
	 * @param School $school
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Exception
	 */
	public function destroy(School $school)
	{
		if (auth()->user()->cannot('delete', $school)) {
			return redirect('home')->with('alert.danger', 'You do not have access to update schools');
		}
		$this->school->destroy($school->id);

		return redirect()->route('schools.index')->with('alert.success', 'School deleted!');
	}
}
