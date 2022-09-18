<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Nomenclature;


class ImageController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');  // ->except('index')

        //$this->middleware('role:logist');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Image::class);

        $validatedData = $request->validate([
            'images.*' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'nomenclature_id' => 'required|integer|min:1',
        ]);

        //$images = $validatedData['images'];

        $nomenclature = Nomenclature::findOrFail($validatedData['nomenclature_id']);

        $data = [];
        if($request->hasfile('images'))
        {
            foreach($request->file('images') as $file)
            {
                $name=$file->getClientOriginalName();
                //$file->move(public_path().'/files/', $name);  
                //$path = $request->file('images')->store('public/img');
                $file->move(public_path().'/img/', $name);  
                $data[] = ['name' => $name];
            }
        }

        $nomenclature->images()->createMany($data);

        return redirect()->back()->with('status', 'Image Has been uploaded');
        //return redirect('upload-image')->with('status', 'Image Has been uploaded');
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }
}
