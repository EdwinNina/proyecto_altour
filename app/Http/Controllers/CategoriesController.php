<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;

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
    public function store(CategoryRequest $request)
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
            $category = Category::findOrFail($request->id);
            
            if($request->file('image')){
                $path =  public_path() .'/images/categories/';
                $url_image = $path.$category->image;
                unlink($url_image);
                
                $file = $request->file('image');
                $name = time().$file->getClientOriginalName();
                $file->move($path,$name);
                $category->name = $request->name;
                $category->image = $name;
                $category->save();
            }else{
                $category->name = $request->name;
                $category->image = $request->image;
                $category->save();
            }
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
