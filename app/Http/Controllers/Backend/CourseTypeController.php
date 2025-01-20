<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseType;

class CourseTypeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    /**
     * Index
     **/
    public function index(Request $request,$id='')
    {
        $data = CourseType::get();
        $details = array();
        if(!empty($id)){
            $details = CourseType::findOrFail($id);
        }
        return view('backend.admin.course.type.index', compact('data','details','id'));
    }

    /**
     * Create
     **/
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:course_type,name|max:100'
        ]);

        $params = $request->except('_token');
        CourseType::insert($params);

        \Session::flash('success', 'Created successfully.');
        return redirect(route('course-type.index'));
    }

    /**
     * Update
     **/
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100|unique:course_type,name,'.$id
        ]);

        $params = $request->except('_token');
        $params['updated_at'] = date('Y-m-d H:i:s');
        CourseType::where('id', $id)->update($params);

        \Session::flash('success', 'Update successfully.');
        return redirect(route('course-type.index'));
    }
}
