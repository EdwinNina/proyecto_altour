<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == ''){
            $categories = Category::orderBy('id','desc')->paginate(5);
        }else{
            $categories = Category::where($criterio, 'like', '%' . $buscar . '%')->orderBy('id','desc')->paginate(5);
        }
        return [
            'categories' => $categories,
            'pagination' => [
                'total'         => $categories->total(),
                'current_page'  => $categories->currentPage(),
                'per_page'      => $categories->perPage(),
                'last_page'     => $categories->lastPage(),
                'from'          => $categories->firstItem(),
                'to'            => $categories->lastItem()
            ]
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()){
            $file = $request->file('image');
            $file_name = time().$file->getClientOriginalName();
            $file->move(public_path().'/images/categories/',$file_name);

            $category = new Category();
            $category->name = $request['name'];
            $category->image = $file_name;
            $category->save();
        }
    }

    public function update(Request $request)
    {
        if($request->ajax()){
            if($request->option == 'nuevo'){
                $file = $request->file('image');
                $file_name = time().$file->getClientOriginalName();
                $file->move(public_path().'/images/categories/',$file_name);
                Category::findOrFail($request->id)->update([
                    'name' => $request->name,
                    'image' => $request->$file_name
                ]);
            }
            Category::findOrFail($request->id)->update([
                'name' => $request->name,
                'image' => $request->image
            ]);
        }
    }


    public function active(Request $request)
    {
        Category::findOrFail($request->id)->update([
            'status' => '1'
        ]);
    }
    public function desactive(Request $request)
    {
        Category::findOrFail($request->id)->update([
            'status' => '0'
        ]);
    }

    public function selectCategory()
    {
        $categories = Category::select('id','name')->where('status','1')->get();
        return $categories;
    }
}
