<?php

namespace App\Http\Controllers;

use App\Place;
use Illuminate\Http\Request;
use App\Http\Requests\PlaceRequest;

class PlaceController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == ''){
            $places = Place::with('category')->orderBy('id','desc')->paginate(5);
        }else{
            $places = Place::with('category')->where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(5);
        }
        return [
            'places' => $places,
            'pagination' => [
                'total' => $places->total(),
                'current_page' => $places->currentPage(),
                'per_page' => $places->perPage(),
                'last_page' => $places->lastPage(),
                'from' => $places->firstItem(),
                'to' => $places->lastItem()
            ] 
        ];
    }

    public function store(PlaceRequest $request)
    {
        if(!$request->ajax()) return redirect('/');

        $file = $request->file('image');
        $file_name = time().$file->getClientOriginalName();
        $file->move(public_path().'/images/places/',$file_name);
        Place::create([
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
        if(!$request->ajax()) return redirect('/');
        
        $place = Place::findOrFail($request->id);
        if($request->file('image')){

            $path_url = public_path().'/images/places/';
            unlink($path_url.$place->image);
            
            $file = $request->file('image');
            $file_name = time().$file->getClientOriginalName();
            $file->move($path_url,$file_name);

            $place->category_id = $request->category_id;
            $place->name = $request->name;
            $place->description = $request->description;
            $place->address = $request->address;
            $place->latitude = $request->latitude;
            $place->longitude = $request->longitude;
            $place->image = $file_name;
            $place->save();
        }else{
            Place::findOrFail($request->id)->update($request->all());
        }
    }

    public function detail(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $place = Place::join('categories','categories.id','=','places.category_id')
                    ->select('places.name','places.description','places.image',
                             'places.latitude','places.longitude','places.address',
                             'categories.name as categoryName')
                    ->where('places.id',$request->id)
                    ->first();
        return $place;
    }

    public function desactive(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        Place::findOrFail($request->id)->update([
            'status' => '0'
        ]);
    }

    public function active(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        Place::findOrFail($request->id)->update([
            'status' => '1'
        ]);
    }

    public function selectPlaces()
    {
        $places = Place::select('id','name')
            ->orderBy('name','desc')
            ->get();
                                
        return $places;
    }
}
