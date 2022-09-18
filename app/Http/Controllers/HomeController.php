<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Nomenclature;
use App\Models\Image;

use Gloudemans\Shoppingcart\Facades\Cart;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
     
        $nomenclatures = Nomenclature::OfActive()->with('images')->get();

        return view('home.home', compact('nomenclatures'));
    }

    public function show($id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->route('home.index')
                        ->withErrors($validator)
                        ->withInput();
        }        

        $nomenclature = Nomenclature::findOrFail($id);

        $nomenclature->load('images');

        $images = $nomenclature->images()->orderByDesc('main')->get();

        return view('home.show', compact('nomenclature', 'images'));
    }    

    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|integer|min:1',
        ]);

        $nomenclature = Nomenclature::findOrFail($data['id']);

        $cartItem = Cart::add($nomenclature, 1);

        return redirect()->back();
    } 

    public function cart(){

        return view('home.showcart');

    }

    public function confirmorder(){

        $data = $this->validateRequest();

        $nomenclatures = $data['nomenclatures'];
        $prices = $data['prices'];
        $names = $data['names'];

        $details = $this->getArrayDetails($nomenclatures, $prices, $names);

        Cart::destroy();

        foreach ($details as $value) {
            Cart::add($value)->associate('Nomenclature');
        }

        Cart::store('username');
        
        //dd(Cart::content());

        return view('home.create');
    }

    private function validateRequest(){

        $data = request()->validate([
            "nomenclatures" => "required|array",
            'nomenclatures.*.qty' => 'sometimes',
            "prices" => "required|array",
            'prices.*.price' => 'required|numeric',
            "names" => "required|array",
            'names.*.name' => 'required|string',
        ]);

        $messages = [
        ];

        $nomenclatures = $data['nomenclatures'];
        $sum_qty = collect($nomenclatures)->sum('qty');

        if (!($sum_qty > 0)){

            $messages = [
                'nomenclatures.required' => 'The field QTY must be filled !!!',
            ];

            Validator::make(['nomenclatures' => null], [
                "nomenclatures" => 'required'
            ], $messages)->validate();
        }

        return $data;
    }

    private function getArrayDetails($nomenclatures, $prices, $names)
    {
        $details = [];

        if (!is_array($nomenclatures)){
            return $details;
        }
        if (!is_array($prices)){
            return $details;
        }
        if (!is_array($names)){
            return $details;
        }


        foreach ($nomenclatures as $nomenclature_id => $value) {

            $qty = (int) $value['qty'];

            if (is_null($qty) || $qty == 0){
                continue;
            }

            if ($qty < 0) {
                $qty = - $qty;
            }

            $price = (int) $prices[$nomenclature_id]['price'];
            $name = $names[$nomenclature_id]['name'];

            $details[] = [
                'id' => $nomenclature_id,
                'name' => $name,
                'qty' => $qty,
                'price' => $price,
            ];
        }

        return $details;
    }

    public function storeorder(){

        //$data = request()->all();

        $data = request()->validate([
            "phone" => "required|min:10",
            "name" => "required|min:3",
            "settlement_id" => "required|min:1",
            "address" => "",
            "comment" => "",
        ]);

        dd($data);

    }

}
