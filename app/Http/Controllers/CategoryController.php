<?php

namespace App\Http\Controllers;

use App\Category;
use App\Exceptions\UnauthorizedException;
use App\Http\Requests\StoreCategory;
use App\Http\Requests\UpdateCategory;

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
     * @throws UnauthorizedException
     */
    public function create()
    {
        if (auth()->user()->cannot('create', $this->category)) {
            throw new UnauthorizedException();
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
        $this->category->create($request->only('name'));

        return redirect('home')->with('alert.success', 'Category created!');
    }

    /**
     * Returns the form to update specified category
     *
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws UnauthorizedException
     */
    public function edit(Category $category)
    {
        if (auth()->user()->cannot('update', $category)) {
            throw new UnauthorizedException();
        }
        $category = $this->category->find($category->id);

        return view('categories.edit')->with('category', $category);
    }

    /**
     * Updates the specified category in storage
     *
     * @param UpdateCategory $request
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateCategory $request, Category $category)
    {
        $category->update($request->only('name'));

        return redirect('home')->with('alert.success', 'Category updated!');
    }

    /**
     * Removes the specified category from storage
     *
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws UnauthorizedException
     */
    public function destroy(Category $category)
    {
        if (auth()->user()->cannot('delete', $category)) {
            throw new UnauthorizedException();
        }
        $this->category->destroy($category->id);

        return redirect('home')->with('alert.success', 'Category deleted!');
    }
}
