<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCategoryStoreRequest;
use App\Http\Requests\ProductCategoryUpdateRequest;
use App\Http\Resources\ProductCategoryIndexResource;
use App\Http\Resources\ProductCategoryShowResource;
use App\Http\Resources\ProductIndexResource;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function product($slug){
        $categories = ProductCategory::whereSlug($slug)->where('published', true)->with(['products'])->get();
        return response($categories);
    }

    public function index($skip = 0)
    {
//        $categories = ProductCategory::where('published', true)->get();
//        $categories = ProductCategory::where('published', true)->with(['products'])->get();
//        $categoriesCollection = ProductCategoryIndexResource::collection($categories);
//        return response($categoriesCollection);



        $categories = ProductCategory::where('published', true)->with(['products'])->skip($skip)->take(3)->orderBy('created_at', 'desc')->get();
        $categoryCollection = ProductCategoryIndexResource::collection($categories);
        return response($categoryCollection);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
//    public function store(ProductCategoryStoreRequest $request)
    public function store(ProductCategoryStoreRequest $request)
    {
//        try {
//            $category = new ProductCategory([
//                'slug' => $request->input('slug'),
//                'name' => $request->input('name'),
//                'published' => $request->input('published'),
//            ]);
//            return response($category->save());
//        } catch (\Throwable $th) {
//            return $th;
//        }

//        $validated = $request->validate([
//            'slug' => 'required|unique:posts|max:255',
//            'name' => 'required',
//        ]);



//        return response($request);
        $category = new ProductCategory([
                'slug' => $request->input('slug'),
                'name' => $request->input('name'),
                'published' => $request->input('published'),
            ]);
        return response($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug, $skip = 0)
    {
//        $category = ProductCategory::where('published', true)->with(['products'])->findOrFail($id);
//        $category = ProductCategory::where('published', true)->whereSlug($slug)->with(['products'])->firstOrFail();
        $category = ProductCategory::whereSlug($slug)->firstOrFail();
        $res = Product::where('published', true)->where('category_id', $category->id)->with(['user', 'category'])->skip($skip)->take(25)->orderBy('created_at', 'desc')->get();
//        return response(new ProductCategoryShowResource($category));
        return response( $res);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCategoryUpdateRequest $request, $slug)
    {
//        $category = ProductCategory::findOrFail($id);
        $category = ProductCategory::where('published', true)->whereSlug($slug)->with(['products'])->firstOrFail();
        $category->slug = $request->input('slug');
        $category->name = $request->input('name');
        $category->published = $request->input('published');
        return response($category->save());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = ProductCategory::findOrFail($id);
        return response($category->delete());
    }
}
