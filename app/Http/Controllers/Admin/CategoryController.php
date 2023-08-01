<?php

namespace App\Http\Controllers\Admin;

use session;
use App\Models\Image;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Psy\Readline\Hoa\Console;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     */
 
    public function trash(){
        $categories = Category::with('images')
        ->onlyTrashed()
        ->get();
        return view('Admin.category.trash', compact('categories'));
    }
    public function restorecat($id){
        $category= Category::onlyTrashed()->findorfail($id);
    
        $category->restore();
       
       
        return redirect()->back();
    }
    public function index(Request $request)
    {
    //   dd(Auth::user());
        
        $categories = Category::with('parent')
        ->when($request->search ,function($query,$value){
        
            $query->where('name','LIKE',"%{$value}%")
             ->orWhere('desc','LIKE',"%{$value}%");
    
            })
              ->when($request->parent_id,function($query,$value){
                $query->where('parent_id','like',$value);
        })
        
        // // ->leftjoin('categories as parents','parents.id','=','categories.parent_id' )
        // // ->select(['categories.*','parents.name as parent_name'])
        ->get();
       
        $parents=Category::orderBy('name','asc')->get();
        return view('Admin.category.index', compact('categories','parents'));
      
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {

        // dd($request->all());

        // $request->validate([
        //   'name'=>'required'|'string'|'max:12',

        // ]);
        DB::beginTransaction();
        try {
            $category = new Category;
            $category->name = $request->name;
            $category->desc = $request->desc;
            $category->save();


            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagefile = new Image;
                    $imagefile->category_id = $category->id;
                    $path = public_path('images/');
                    $filename = $image->getClientOriginalName();
                    $image->move($path, $filename);
                    $imagefile->image = $filename;
                    $imagefile->save();
                }
            }



            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            return $exception;
        }


        return redirect()->back()
            ->with('success', 'Your changes have been saved successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);
        $images = Image::where('category_id', $id)->get();
        // dd($images);
        return view('Admin.category.show', ['category' => $category, 'images' => $images]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findorfail($id);
        $images = Image::where('category_id', $id)->get();
        return view('Admin.category.edit')->with([
            'category' => $category,
            'images' => $images
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->desc = $request->desc;
        $category->save();

        //$existingImageIds = $category->images->pluck('id')->toArray();

        if ($request->hasFile('images')) {




            foreach ($request->file('images') as $image) {

                $imageModel = new Image();

                $imageModel->category_id = $category->id;
                $path = public_path('images/');
                $filename = $image->getClientOriginalName();

                $image->move($path, $filename);
                $imageModel->image = $filename;
                $imageModel->save();
            }
        }


        return redirect()->back()->with('success', 'Update has been done');
    }
    // In this updated code, a new Image model instance ($imageModel) is created for each image file, and then the image is saved individually.








    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
      $category=Category::with('images')->findorfail($id);
      $category->delete();
      return redirect()->back()->with('message','delete has been done');

    }
    public function forcedelete(string $id)
    {
      $category=Category::onlyTrashed()->findorfail($id);
      $category->forceDelete();
      return redirect()->back()->with('message','delete has been done forever');

    }

    public function delete($imageId)
    {
        // Retrieve the image record based on the ID

        // Delete the image file on the server
        $image = Image::find($imageId);
        // return $image;
        // $filename = $images->getClientOriginalName();
        $path = public_path('images/') . $image->image;
        unlink($path);
        // Delete the image record from the database
        $image->delete();

        return response()->json(['success' => true]);
    }
}
