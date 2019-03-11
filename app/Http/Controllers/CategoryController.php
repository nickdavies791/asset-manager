<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\StoreCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
	protected $category;

	/**
	 * CategoryController constructor.
	 * @param Category $category
	 */
	public function __construct(Category $category)
	{
		$this->category = $category;
	}

	/**
	 * Returns the form to create new categories
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function create()
    {
        if (auth()->user()->cannot('create', $this->category)) {
        	return redirect('home')->with('alert.danger', 'You do not have access to create categories');
		}

        return view('categories.create');
    }

	/**
	 * Stores a newly created category in storage
	 *
	 * @param StoreCategory $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store(StoreCategory $request)
    {
		if (auth()->user()->cannot('create', $this->category)) {
			return redirect('home')->with('alert.danger', 'You do not have access to create categories');
		}

		$this->category->create([
			'name' => $request->name
		]);

		return redirect('home')->with('alert.success', 'Category created!');
    }

	/**
	 * Returns the form to update specified category
	 *
	 * @param Category $category
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function edit(Category $category)
    {
        if (auth()->user()->cannot('update', $category)) {
        	return redirect('home')->with('alert.danger', 'You do not have access to update categories');
		}
        $category = $this->category->find($category->id);

        return view('categories.edit')->with('category', $category);
    }

	/**
	 * Updates the specified category in storage
	 *
	 * @param Request $request
	 * @param Category $category
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function update(Request $request, Category $category)
    {
        if (auth()->user()->cannot('update', $category)) {
        	return redirect('home')->with('alert.danger', 'You do not have access to update categories');
		}
        $category->name = $request->name;
        $category->save();

        return redirect('home')->with('alert.success', 'Category updated!');
    }

	/**
	 * Removes the specified category from storage
	 *
	 * @param Category $category
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function destroy(Category $category)
    {
		if (auth()->user()->cannot('delete', $category)) {
			return redirect('home')->with('alert.danger', 'You do not have access to delete categories');
		}
		$this->category->destroy($category->id);

		return redirect('home')->with('alert.success', 'Category deleted!');
    }
}
