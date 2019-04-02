<?php

namespace App\Http\Controllers;

use App\Exceptions\UnauthorizedException;
use App\Http\Requests\StoreType;
use App\Http\Requests\UpdateType;
use App\Type;

class TypeController extends Controller
{
    /**
     * The Type model instance.
     *
     * @var Type $type
     */
    protected $type;

    /**
     * TypeController constructor.
     *
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
     * @throws UnauthorizedException
     */
    public function create()
    {
        if (auth()->user()->cannot('create', $this->type)) {
            throw new UnauthorizedException();
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
        $this->type->create($request->only('name'));

        return redirect('home')->with('alert.success', 'Type created!');
    }

    /**
     * Returns the form to update the specified type
     *
     * @param Type $type
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws UnauthorizedException
     */
    public function edit(Type $type)
    {
        if (auth()->user()->cannot('update', $type)) {
            throw new UnauthorizedException();
        }
        $type = $this->type->find($type->id);

        return view('types.edit')->with('type', $type);
    }

    /**
     * Updates the specified type in storage
     *
     * @param UpdateType $request
     * @param Type $type
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateType $request, Type $type)
    {
        $type->update($request->only('name'));

        return redirect('home')->with('alert.success', 'Type updated!');
    }

    /**
     * Removes the specified type from storage
     *
     * @param Type $type
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws UnauthorizedException
     */
    public function destroy(Type $type)
    {
        if (auth()->user()->cannot('delete', $type)) {
            throw new UnauthorizedException();
        }
        $this->type->destroy($type->id);

        return redirect('home')->with('alert.success', 'Type deleted!');
    }
}
