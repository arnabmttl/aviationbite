<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\BannerStoreRequest;
use App\Http\Requests\Backend\BannerUpdateRequest;
use App\Models\Banner;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File; 

class BannerController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('role:admin');
    }

    /**
     * index
     **/
    public function index(Request $request)
    {
        # code...

        $data = Banner::orderBy('id', 'desc')->get();

        return view('backend.admin.banner.index', compact('data'));
    }
    
    public function create()
    {
        return view('backend.admin.banner.create');
    }

    public function store(BannerStoreRequest $request)
    {
        $input = $request->validated();
        if(!empty($input['image'])){
            $inputFile = $input['image'];
            $fileName = uniqid().''.date('y-m-d-h-i-s');
            $fileExtension = $inputFile->getClientOriginalExtension();
            $uploadPath = 'storage/banners/';

            $inputFile->move(public_path($uploadPath), $fileName.'.'.$fileExtension);
            $imagePath = $uploadPath.$fileName.'.'.$fileExtension;
            // dd($imagePath);
            unset($input['image']);

            $input['image'] = $imagePath;
        }

        // dd($input);

        Banner::insert($input);
        Session::flash('success', 'The banner created successfully.');
        
        return redirect(route('banner.index'));
    }

    /**
     * Edit
     **/
    public function edit(Banner $banner)
    {
        return view('backend.admin.banner.edit', compact('banner'));
    }

    /**
     * Update
     **/
    public function update(Banner $banner, BannerUpdateRequest $request)
    {
        # code...

        $input = $request->validated();
        if(!empty($input['image'])){
            if (File::exists($banner->image)) {
                unlink($banner->image);                
            }
            $inputFile = $input['image'];
            $fileName = uniqid().''.date('y-m-d-h-i-s');
            $fileExtension = $inputFile->getClientOriginalExtension();
            $uploadPath = 'storage/banners/';

            $inputFile->move(public_path($uploadPath), $fileName.'.'.$fileExtension);
            $imagePath = $uploadPath.$fileName.'.'.$fileExtension;
            // dd($imagePath);
            unset($input['image']);

            $input['image'] = $imagePath;
        } else {
            $input['image'] = $banner->image;
        }
        Banner::where('id',$banner->id)->update($input);
        Session::flash('success', 'The banner updated successfully.');        
        return redirect(route('banner.index'));
    }

    /**
     * Delete banner
     **/
    public function destroy(Banner $banner)
    {        
        if (File::exists($banner->image)) {
            unlink($banner->image);
        }
        $banner->delete();
        Session::flash('success', 'The banner deleted successfully.');        
        return redirect(route('banner.index'));        

    }
}
