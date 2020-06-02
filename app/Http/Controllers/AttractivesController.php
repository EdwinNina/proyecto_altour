<?php

namespace App\Http\Controllers;

use App\Attractive;
use Illuminate\Http\Request;
use App\Http\Requests\AttractiveRequest;

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

    public function store(AttractiveRequest $request)
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
        if($request->ajax()){
            $attractive = Attractive::findOrFail($request->id);
            if($request->file('image')){

                $path_url = public_path().'/images/attractives/';
                unlink($path_url.$attractive->image);
                
                $file = $request->file('image');
                $file_name = time().$file->getClientOriginalName();
                $file->move($path_url,$file_name);

                $attractive->category_id = $request->category_id;
                $attractive->name = $request->name;
                $attractive->description = $request->description;
                $attractive->address = $request->address;
                $attractive->latitude = $request->latitude;
                $attractive->longitude = $request->longitude;
                $attractive->image = $file_name;
                $attractive->save();
            }else{
                Attractive::findOrFail($request->id)->update($request->all());
            }
        }
    }

    public function detail(Request $request)
    {
        $attractive = Attractive::join('categories','categories.id','=','attractives.category_id')
                    ->select('attractives.name','attractives.description','attractives.address',
                             'attractives.longitude','attractives.latitude','attractives.image',
                             'categories.name as categoryName')
                    ->where('attractives.id',$request->id)
                    ->first();
        return $attractive;
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

    public function selectAttractives()
    {
        $attractives = Attractive::select('id','name')
                                ->orderBy('name','desc')
                                ->get();
                                
        return $attractives;
    }
}
