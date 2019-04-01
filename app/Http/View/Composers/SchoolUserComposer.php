<?php

namespace App\Http\View\Composers;

use App\School;
use Illuminate\View\View;

class SchoolUserComposer
{
    protected $school;

    /**
     * SchoolUserComposer constructor.
     * @param School $school
     */
    public function __construct(School $school)
    {
        $this->school = $school;
    }

    /**
     * Bind data to the view
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('schools', auth()->user()->schools);
    }
}
