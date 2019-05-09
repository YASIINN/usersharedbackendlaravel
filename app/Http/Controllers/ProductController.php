<?php
namespace App\Http\Controllers;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ProductController extends Controller
{

            public function update(Request $request){
                DB::beginTransaction();
                $data= $request->updatedata;
                $updated=  app('App\Http\Controllers\UpdateDataParseController')->updateparse($data);
                $queryparse=$request->urlparse;
                $parser=  app('App\Http\Controllers\UrlParseController')->queryparser($queryparse);
                $setproduct= DB::table('product')
                ->where($parser)
                ->update($updated);
                if($setproduct){
                    DB::commit();
                    return response()->json(array(['status'=>"Updated"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
                }else{
                    DB::rollback();
                    return response()->json(array(['status'=>"Error"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
                }
            }

        public function softdelete(Request $request){
            DB::beginTransaction();
            $queryparse=$request->urlparse;
            $parser=  app('App\Http\Controllers\UrlParseController')->queryparser($queryparse);
            $setproduct= DB::table('product')
            ->where($parser)
            ->update(['productstatus' =>5
            ]);
            if($setproduct){
                DB::commit();
                return response()->json(array(['status'=>"Deleted"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
            }else{
                DB::rollback();
                return response()->json(array(['status'=>"Error"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
            }
        }

    public function add(Request $request){
        DB::beginTransaction();
        $newproduct=DB::table('product')->insertGetId(
                [
                    "title"=>$request->title,
                    "descraption"=>$request->descraption,
                    "price"=>$request->price,
                    "oldprice"=>$request->price,
                    "category"=>$request->category,
                    "productstatus"=>$request->status,
                    "cityid"=>$request->city,
                    "prdate"=>$request->date,
                    "prtime"=>$request->time,
                    "university"=>$request->university
                ]
        );
        if($newproduct){
            DB::commit();
                return response()->json(array(['status'=>"InsertedProduct",'id'=>$newproduct]), 200,['Content-type'=> 'application/json; charset=utf-8']);
        }else{
            DB::rollback();
                return response()->json(array(['status'=>"NotInserted"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
        }
    }
        public function getproductdetail(Request $request){
            DB::beginTransaction();
            $queryparse=$request->urlparse;
            $parser=  app('App\Http\Controllers\UrlParseController')->queryparser($queryparse);
              $products=DB::table('product')
              ->join('productstatus', 'product.productstatus', '=', 'productstatus.id')
              ->join('userproduct', 'product.productid', '=', 'userproduct.productid')
              ->join('user', 'userproduct.userid', '=', 'user.userid')
              ->join('contact', 'user.userid', '=', 'contact.userid')
              ->join('avatar', 'user.avatarid', '=', 'avatar.avatarid')
              ->join('category', 'product.category', '=', 'category.id')
              ->join('city', 'product.cityid', '=', 'city.cityid')
              ->join('university', 'product.university', '=', 'university.universityid')
              ->join('productphotos', 'product.productid', '=', 'productphotos.productid')
              ->join('photo', 'productphotos.photoid', '=', 'photo.id')
              ->select('product.*','productstatus.*','userproduct.*','user.*','category.*','city.*' ,'university.*','productphotos.*','photo.*','contact.*','avatar.*')
              ->where($parser)
              ->get();
              if(count($products)>0){
                $favcount= app('App\Http\Controllers\FavProductController')->favprcount($products[0]->productid);
                $seencount= app('App\Http\Controllers\UserSeenProductController')->seencount($products[0]->productid);
              for($i=0;$i<count($products);$i++){
                             $product[] = array(
                                "productid"=>$products[$i]->productid,
                                "title"=>$products[$i]->title,
                                "descraption"=>$products[$i]->descraption,
                                "price"=>$products[$i]->price,
                                "oldprice"=>$products[$i]->oldprice,
                                "categoryid"=>$products[$i]->category,
                                "categorytxt"=>$products[$i]->categorytxt,
                                "productstatus"=>$products[$i]->productstatus,
                                "status"=>$products[$i]->status,
                                "cityid"=>$products[$i]->cityid,
                                "cityname"=>$products[$i]->cityname,
                                "date"=>$products[$i]->date,
                                "time"=>$products[$i]->time,
                                "university"=>$products[$i]->university,
                                "universityname"=>$products[$i]->universityname,
                                "seqnumber"=>$products[$i]->seqnumber,
                                "img" =>  "data:image/jpeg:image/png;base64,".base64_encode($products[$i]->photo),
                                "favcount"=>$favcount,
                                "seencount"=>$seencount,
                                "username"=>$products[$i]->username,
                                "usname"=>$products[$i]->usname,
                                "uslname"=>$products[$i]->uslname,
                                "userid"=>$products[$i]->userid,
                                "avatarid" => $products[$i]->avatarid,
                                "imagesid"=>$products[$i]->photoid,
                                "avatar" =>"data:image/jpeg:image/png;base64,".base64_encode($products[0]->avatar),
                                        );

            }

            DB::commit();
                        return response()->json(["data"=>$product], 200,['Content-type'=> 'application/json; charset=utf-8']);
                    }
                        else{
                            DB::rollback();
                            return response()->json(array(['status'=>"Not"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
                        }

                }


    public function getproduct(Request $request){
        DB::beginTransaction();
        $queryparse=$request->urlparse;
      $parser= app('App\Http\Controllers\UrlParseController')->queryparser($queryparse);
        $products=DB::table('product')
        ->join('productstatus', 'product.productstatus', '=', 'productstatus.id')
        ->join('userproduct', 'product.productid', '=', 'userproduct.productid')
        ->join('user', 'userproduct.userid', '=', 'user.userid')
        ->join('contact', 'user.userid', '=', 'contact.userid')
        ->join('avatar', 'user.avatarid', '=', 'avatar.avatarid')
        ->join('category', 'product.category', '=', 'category.id')
        ->join('city', 'product.cityid', '=', 'city.cityid')
        ->join('university', 'product.university', '=', 'university.universityid')
        ->join('productphotos', 'product.productid', '=', 'productphotos.productid')
        ->join('photo', 'productphotos.photoid', '=', 'photo.id')
        ->select('product.*','productstatus.*','userproduct.*','user.*','category.*','city.*' ,'university.*','productphotos.*','photo.*','contact.*','avatar.*')
        ->where($parser)
        ->orderBy('product.productid', 'desc')
        ->get();
        $totalmoney=0;
        if(count($products)>0){
        for($i=0;$i<count($products);$i++){
            $totalmoney+=(int)$products[$i]->price;
            $favcount= app('App\Http\Controllers\FavProductController')->favprcount($products[$i]->productid);
            $seencount= app('App\Http\Controllers\UserSeenProductController')->seencount($products[$i]->productid);
            $product[] = array(
                    "productid"=>$products[$i]->productid,
                    "title"=>$products[$i]->title,
                    "descraption"=>$products[$i]->descraption,
                    "price"=>$products[$i]->price,
                    "oldprice"=>$products[$i]->oldprice,
                    "categoryid"=>$products[$i]->category,
                    "categorytxt"=>$products[$i]->categorytxt,
                    "productstatus"=>$products[$i]->productstatus,
                    "status"=>$products[$i]->status,
                    "cityid"=>$products[$i]->cityid,
                    "cityname"=>$products[$i]->cityname,
                    "date"=>$products[$i]->prdate,
                    "time"=>$products[$i]->prtime,
                    "university"=>$products[$i]->university,
                    "universityname"=>$products[$i]->universityname,
                    "img" =>"data:image/jpeg:image/png;base64,".base64_encode($products[$i]->photo),
                    "favcount"=>$favcount,
                    "seencount"=>$seencount,
                    "username"=>$products[$i]->username,
                    "usname"=>$products[$i]->usname,
                    "uslname"=>$products[$i]->uslname,
                    "userid"=>$products[$i]->userid,
                    "avatarid" => $products[$i]->avatarid,
                    "avatar" =>"data:image/jpeg:image/png;base64,".base64_encode($products[$i]->avatar),
                            );
        }
        $arrcount=count($product);
        if($request->pagination=="0"){
            $product=$product;
        }
        else if($request->pagination=="1"){
            $product= array_slice($product, 0,10);
        }else if ($request->pagination){
            $product= array_slice($product, (10*$request->pagination)-10,10*$request->pagination);
        }
        DB::commit();
    return response()->json(["data"=>$product,"count"=>$arrcount,"totalmoney"=>$totalmoney], 200,['Content-type'=> 'application/json; charset=utf-8']);
    }else{
        DB::rollback();
        return response()->json(['status'=>"Not"], 200,['Content-type'=> 'application/json; charset=utf-8']);
    }
    }
}
