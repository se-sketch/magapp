<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nomenclature;
use App\Models\Image;


class NomenclaturesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  // ->except('index')

        //$this->middleware('role:logist');
    }

    public function index()
    {
        $this->authorize('viewAny', Nomenclature::class);

        /*
        $nomenclature = Nomenclature::findOrFail(1);
        $image = $nomenclature->getMainImage();
        dd($image);
        */

        $nomenclatures = Nomenclature::orderBy('active', 'desc')
        ->orderBy('id', 'desc')->get();

        return view('nomenclatures.index', compact('nomenclatures'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Nomenclature::class);

        $nomenclature = new Nomenclature();

        $images = [];

        return view('nomenclatures.create', compact('nomenclature', 'images'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Nomenclature::class);

        $data = $this->validateRequest();
        $dataImages = $this->validateImages();

        $nomenclature = Nomenclature::create($data);

        $data = $this->store_image_get_data($dataImages);

        $nomenclature->images()->createMany($data);

        return redirect('nomenclatures');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Nomenclature  $nomenclature
     * @return \Illuminate\Http\Response
     */
    public function show(Nomenclature $nomenclature)
    {
        $this->authorize('view', $nomenclature);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Nomenclature  $nomenclature
     * @return \Illuminate\Http\Response
     */
    public function edit(Nomenclature $nomenclature)
    {
        $this->authorize('update', $nomenclature);

        $nomenclature->load('images');

        $images = $nomenclature->images()->orderByDesc('main')->get();

        return view('nomenclatures.edit', compact('nomenclature', 'images'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Nomenclature  $nomenclature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nomenclature $nomenclature)
    {
        $this->authorize('update', $nomenclature);

        $dataImages = $this->validateImages();

        $nomenclature->update($this->validateRequest());

        $data = $this->store_image_get_data($dataImages);

        $nomenclature->images()->createMany($data);

        return redirect('nomenclatures');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Nomenclature  $nomenclature
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nomenclature $nomenclature)
    {
        $this->authorize('delete', $nomenclature);
    }

    private function validateRequest(){
        
        $data = request()->validate([
            "name" => "required|min:3",
            "price" => "required|numeric",
            "active" => "",
            "balance" => "",
            "description" => "required|string",
            //'images.*' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]); 

        $data["active"] = array_key_exists("active", $data);

        $data["balance"] = array_key_exists("balance", $data);

        return $data;
    }

    private function validateImages(){
        $data = request()->validate([
            'images.*' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        return $data;
    }

    public function delete_image(){

        $this->authorize('create', Nomenclature::class);

        $data = request()->validate([
            'image_id' => 'integer|min:1',
        ]);
        
        $image_id = $data['image_id'];

        $image = Image::findOrFail($image_id);
        
        $image->delete();

        return response()->json(array(
            'image_id' => $image_id,
        ), 200);        
    }

    private function store_image_get_data($dataImages){
        $data = [];

        if (!array_key_exists('images', $dataImages)){
            return $data;
        }

        $files_images = $dataImages['images'];

        foreach($files_images as $file)
        {
            $name = $file->getClientOriginalName();
            //$file->move(public_path().'/files/', $name);  
            //$path = $request->file('images')->store('public/img');

            $directory = 'img/';

            $path = public_path().'/'.$directory;

            $file->move($path, $name);  
            $data[] = ['name' => $name, 'path' => $directory];
        }
        return $data;        
    }

    public function set_main_image(){
        $this->authorize('create', Nomenclature::class);

        $data = request()->validate([
            'image_id' => 'integer|min:1',
        ]);
        
        $image_id = $data['image_id'];

        $image = Image::findOrFail($image_id);
        
        $image->main = ($image->main) ? 0 : 1;

        $image->save();

        return response()->json(array(
            'image_id' => $image_id,
            'main' => $image->main,
        ), 200);        

    }

}