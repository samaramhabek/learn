<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Product;
use App\Models\Category;
use App\Models\ImageProduct;
use Illuminate\Http\Request;
use Psy\Readline\Hoa\Console;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ProductTag;
use Exception;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('imagesproduct')->withoutGlobalScope('sale')
       // ->Sold()
        ->Status('new')
        ->get();
       
        return view('Admin.product.index', compact('products'));
     
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('Admin.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //  dd($request->all());
        //'saleprice' => 'required|lt:price',
        // 'saleprice' => [
        //     'required',
        //     Rule::callback(function ($value) use ($request) {
        //         // Custom validation logic
        //         $price = $request->input('price');
        //         return $value < $price;
        //     })

        // ],
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer|exists:categories,id',
            'price' => 'required',
            'saleprice' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    // Custom validation logic
                    $price = $request->input('price');
                    if ($value >= $price) {
                        $fail('The sale price must be smaller than the regular price.');
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            // Handle validation failure
            // Redirect back or return a response with error messages
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try {
            $product = new Product();
            $product->name = $request->name;
            $product->desc = $request->desc;
            $product->category_id = $request->category_id;
            $product->price = $request->price;
            $product->saleprice = $request->saleprice;
            $product->quantity = $request->quantity;
            $product->brand = $request->brand;
            $product->status = $request->status;
            $product->save();


            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $imagefile = new ImageProduct();

                    $imagefile->product_id = $product->id;
                    $path = public_path('imagesproduct/');
                    $filename = $image->getClientOriginalName();
                    $image->move($path, $filename);
                    $imagefile->image = $filename;
                    $imagefile->save();
                }
            }
           
             $tags = $request->input('tags');
       //   dd(json_decode($tags));
            
           
            foreach (json_decode($tags) as $key => $tag) {
                $tagssave=Tag::where('title', $tag->value)->first();
                      if($tagssave){
                        $product->tags()->attach($tagssave->id);
                      }

                    $tagsnew = new Tag();
                    $tagsnew->title = $tag->value;
                    $tagsnew->save();
                    $product->tags()->attach($tagsnew->id);
                      
                
            }
           
            

            DB::commit();
        } catch (Exception $exception) {

            DB::rollBack();
            return $exception;
        }
        return redirect()->back()->with('success', 'successed create product!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('tags')->findorfail($id);
        
      
        $images = ImageProduct::where('product_id', $id)->get();

        //dd($images);
        return view('Admin.product.show', compact('product', 'images'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::with('tags')->withoutGlobalScope('sale')->findorfail($id);
        // $tags=$product->tags;
        // foreach(json_decode($tags) as  $key => $tag){
        //    $tag->title;
        // }
      //  dd($product);
        $categories = Category::all();
        $images = ImageProduct::where('product_id', $id)->get();
        return view('Admin.product.edit', compact('product', 'categories', 'images'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //  dd($request->all());

        $product = Product::findorfail($id);
        $product->update($request->except('images','tags'));
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                $imageproduct =  new  ImageProduct();
                $filename =  $image->getClientOriginalName();
                $path = public_path('imagesproduct/');
                $image->move($path, $filename);
                $imageproduct->image = $filename;
                $imageproduct->product_id = $product->id;
                $imageproduct->save();
            }
        }
        $tags = $request->input('tags');
        //   dd(json_decode($tags));
             
            
             foreach (json_decode($tags) as $key => $tag) {
                 $tagssave=Tag::where('title', $tag->value)->first();
                       if($tagssave){
                         $product->tags()->attach($tagssave->id);
                       }
 
                     $tagsnew = new Tag();
                     $tagsnew->title = $tag->value;
                     $tagsnew->save();
                     $product->tags()->attach($tagsnew->id);
                       
                 
             }

        return redirect()->back()->with('success', 'successed update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function deleteproduct($imageId)
    {
        // dd($imageId);
        // Retrieve the image record based on the ID

        // Delete the image file on the server
        $image = ImageProduct::find($imageId);
        // return $image;
        // $filename = $images->getClientOriginalName();
        $path = public_path('imagesproduct/') . $image->image;
        unlink($path);
        // Delete the image record from the database
        $image->delete();

        return response()->json(['success' => true]);
    }
}
