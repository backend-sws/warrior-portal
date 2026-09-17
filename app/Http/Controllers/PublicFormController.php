<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subject;
use App\Models\Qualification;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;

class PublicFormController extends Controller
{
    private function getCommonData()
    {
        return [
            'categories'     => Category::where('is_active', true)->orderBy('name')->get(),
            'qualifications' => Qualification::where('is_active', true)->orderBy('name')->get(),
            'allSubjects'    => Subject::where('is_active', true)->orderBy('name')->get(),
            'states'         => State::where('is_active', true)->orderBy('name')->get(),
            'allCities'      => City::where('is_active', true)->orderBy('name')->get(),
        ];
    }

    /**
     * Home Tutor Registration Page
     */
    public function homeTutor()
    {
        $data = $this->getCommonData();
        return view('forms.home-tutor', $data);
    }

    /**
     * School Teacher Registration Page
     */
    public function schoolTeacher()
    {
        $data = $this->getCommonData();
        return view('forms.school-teacher', $data);
    }

    /**
     * Dual Profile (Home Tutor + School Teacher) Registration Page
     */
    public function both()
    {
        $data = $this->getCommonData();
        return view('forms.both', $data);
    }

    /**
     * Parent/Student Need a Home Tutor Requirement Form
     */
    public function needTutor()
    {
        $data = $this->getCommonData();
        return view('forms.need-tutor', $data);
    }

    /**
     * School/Institute Teacher Hiring Requirement Form
     */
    public function hireTeacher()
    {
        $data = $this->getCommonData();
        return view('forms.hire-teacher', $data);
    }
}
