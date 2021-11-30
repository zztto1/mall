<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Model\product_list;
use App\Model\category;

class productController extends Controller
{
     public function __construct()
     {
       $this->middleware('auth')->only(['create', 'store', 'update', 'edit', 'destroy']);
     }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
      if(!isset($req->category)){
        return abort('404');
      }

      $category = category::where([['id', $req->category], ['status', 0]])->first();

      if(!isset($category->id)){
        return abort('404');
      }

      $product = product_list::where([['category_id', $req->category], ['status', 0]])->orderBy('id', 'desc')->paginate(12);

      return view('product', ['product' => $product, 'category' => $category]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $category = category::where('status', 0)->orderBy('tag', 'desc')->get();

      return view('product_write', ['category' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $insert = product_list::insertGetId([
        'category_id' => $request->category,
        'product_code' => $request->code,
        'product_name' => $request->name,
        'product_size' => $request->size,
        'product_desc' => $request->desc,
        'contents' => $request->content
      ]);

      $file_path = storage_path('app/public/product');
      $extension = $request->header_img_1->getClientOriginalExtension();
      $file_name_1 = $insert."_header_img_1.".$extension;
      $request->header_img_1->move($file_path, $file_name_1);
      $file_name_1 = "/storage/product/".$file_name_1;

      if(isset($request->header_img_2)){
        $extension = $request->header_img_2->getClientOriginalExtension();
        $file_name_2 = $insert."_header_img_2.".$extension;
        $request->header_img_2->move($file_path, $file_name_2);
        $file_name_2 = "/storage/product/".$file_name_2;
      }else{
        $file_name_2 = null;
      }

      if(isset($request->header_img_3)){
        $extension = $request->header_img_3->getClientOriginalExtension();
        $file_name_3 = $insert."_header_img_3.".$extension;
        $request->header_img_3->move($file_path, $file_name_3);
        $file_name_3 = "/storage/product/".$file_name_3;
      }else{
        $file_name_3 = null;
      }

      $update = product_list::where('id', $insert)->update([
        'header_img_1' => $file_name_1,
        'header_img_2' => $file_name_2,
        'header_img_3' => $file_name_3
      ]);


      return redirect("/product/".$insert);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!isset($id)){
          return abort('404');
        }

        $product = product_list::selectRaw('product_list.*, tag')->where('product_list.id', $id)->leftjoin('category', 'category.id', '=', 'product_list.category_id')->first();

        if(!isset($product->id)) return abort('404');

        if($product->status == 1) return abort('404');

        $category = category::where([['id', $product->category_id], ['status', 0]])->first();

        return view('product_detail', ['product' => $product, 'category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!isset($id)){
          return abort('404');
        }

        $product = product_list::where('product_list.id', $id)->first();

        if(!isset($product->id)) return abort('404');

        if($product->status == 1) return abort('404');

        $category = category::where('status', 0)->orderBy('tag', 'desc')->get();

        return view('product_edit', ['product' => $product, 'category' => $category]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = product_list::where('id', $id)->update([
          'category_id' => $request->category,
          'product_code' => $request->code,
          'product_name' => $request->name,
          'product_size' => $request->size,
          'product_desc' => $request->desc,
          'contents' => $request->content
        ]);

        $file_path = storage_path('app/public/product');

        if($request->header_img_1_change == "Y"){
          $extension = $request->header_img_1->getClientOriginalExtension();
          $file_name_1 = $id."_header_img_1.".$extension;
          $request->header_img_1->move($file_path, $file_name_1);
          $file_name_1 = "/storage/product/".$file_name_1;

          $update = product_list::where('id', $id)->update([
            'header_img_1' => $file_name_1
          ]);
        }


        if($request->header_img_2_change == "Y"){
          if(isset($request->header_img_2)){
            $extension = $request->header_img_2->getClientOriginalExtension();
            $file_name_2 = $id."_header_img_2.".$extension;
            $request->header_img_2->move($file_path, $file_name_2);
            $file_name_2 = "/storage/product/".$file_name_2;
          }else{
            $file_name_2 = null;
          }

          $update = product_list::where('id', $id)->update([
            'header_img_2' => $file_name_2
          ]);
        }

        if($request->header_img_3_change == "Y"){
          if(isset($request->header_img_3)){
            $extension = $request->header_img_3->getClientOriginalExtension();
            $file_name_3 = $id."_header_img_3.".$extension;
            $request->header_img_3->move($file_path, $file_name_3);
            $file_name_3 = "/storage/product/".$file_name_3;
          }else{
            $file_name_3 = null;
          }

          $update = product_list::where('id', $id)->update([
            'header_img_3' => $file_name_3
          ]);
        }

        return redirect("/product/".$id)->with('alert', "정상적으로 수정되었습니다.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $update = product_list::where('id', $id)->update([
        'status' => 1
      ]);

      return redirect("/")->with('alert', "정상적으로 삭제되었습니다.");
    }
}
