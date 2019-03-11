<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreType;
use App\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
	protected $type;

	/**
	 * TypeController constructor.
	 * @param Type $type
	 */
	public function __construct(Type $type)
	{
		$this->type = $type;
	}

	/**
	 * Returns the form to create new types
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function create()
    {
        if (auth()->user()->cannot('create', $this->type)) {
        	return redirect('home')->with('alert.danger', 'You do not have access to create types');
		}

        return view('types.create');
    }

	/**
	 * Stores a newly created type in storage
	 *
	 * @param StoreType $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store(StoreType $request)
    {
        if (auth()->user()->cannot('create', $this->type)) {
        	return redirect('home')->with('alert.danger', 'You do not have access to create types');
		}

        $this->type->create([
        	'name' => $request->name
		]);

        return redirect('home')->with('alert.success', 'Type created!');
    }

	/**
	 * Returns the form to update the specified type
	 *
	 * @param Type $type
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function edit(Type $type)
    {
    	if (auth()->user()->cannot('update', $type)) {
    		return redirect('home')->with('alert.danger', 'You do not have access to update types');
		}
    	$type = $this->type->find($type->id);

    	return view('types.edit')->with('type', $type);
    }

	/**
	 * Updates the specified type in storage
	 *
	 * @param Request $request
	 * @param Type $type
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function update(Request $request, Type $type)
    {
    	if (auth()->user()->cannot('update', $type)) {
    		return redirect('home')->with('alert.danger', 'You do not have access to update types');
		}
    	$type->name = $request->name;
    	$type->save();

    	return redirect('home')->with('alert.success', 'Type updated!');
    }

	/**
	 * Removes the specified type from storage
	 *
	 * @param Type $type
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function destroy(Type $type)
    {
    	if (auth()->user()->cannot('delete', $type)) {
    		return redirect('home')->with('alert.danger', 'You do not have access to delete types');
		}
    	$this->type->destroy($type->id);

    	return redirect('home')->with('alert.success', 'Type deleted!');
    }
}
