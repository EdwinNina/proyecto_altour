<?php

namespace App\Http\Controllers;

use App\Attractive;
use Illuminate\Http\Request;

class AttractivesController extends Controller
{

    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == ''){
            $attractives = Attractive::with('category')->orderBy('id','desc')->paginate(5);
        }else{
            $attractives = Attractive::with('category')->where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(5);
        }
        return [
            'attractives' => $attractives,
            'pagination' => [
                'total' => $attractives->total(),
                'current_page' => $attractives->currentPage(),
                'per_page' => $attractives->perPage(),
                'last_page' => $attractives->lastPage(),
                'from' => $attractives->firstItem(),
                'to' => $attractives->lastItem()
            ] 
        ];
    }

    public function store(Request $request)
    {
        $file = $request->file('image');
        $file_name = time().$file->getClientOriginalName();
        $file->move(public_path().'/images/attractives/',$file_name);
        Attractive::create([
            'category_id' => $request['category_id'],
            'name' => $request['name'],
            'description' => $request['description'],
            'address' => $request['address'],
            'latitude' => $request['latitude'],
            'longitude' => $request['longitude'],
            'image' => $file_name,
        ]);
    }

    public function update(Request $request)
    {
        return $request['prueba'];
        if($request->option == 'nuevaImagen'){
            $file = $request->file('image');
            $file_name = time().$file->getClientOriginalName();
            $file->move(public_path().'/images/categories/',$file_name);
            Attractive::findOrFail($request->id)->update([
                'category_id' => $request['category_id'],
                'name' => $request['name'],
                'description' => $request['description'],
                'address' => $request['address'],
                'latitude' => $request['latitude'],
                'longitude' => $request['longitude'],
                'image' => $file_name,
            ]);
        }
        Attractive::findOrFail($request->id)->update($request->all());
    }

    public function detail(Request $request){
        $attractive = Attractive::findOrFail($request->id)->with('category')->first();
        return view('Attractives.detail', compact('attractive'));
    }

    public function desactive(Request $request)
    {
        Attractive::findOrFail($request->id)->update([
            'status' => '0'
        ]);
    }

    public function active(Request $request)
    {
        Attractive::findOrFail($request->id)->update([
            'status' => '1'
        ]);
    }
}
