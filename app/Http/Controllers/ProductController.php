<?php
namespace App\Http\Controllers;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ProductController extends Controller
{

            public function update(Request $request){
                $data= $request->updatedata;
                $updated=  app('App\Http\Controllers\UpdateDataParseController')->updateparse($data);
                $queryparse=$request->urlparse;
                $parser=  app('App\Http\Controllers\UrlParseController')->queryparser($queryparse);
                $setproduct= DB::table('product')
                ->where($parser)
                ->update($updated);
                if($setproduct){
                    return response()->json(array(['status'=>"Updated"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
                }else{
                    return response()->json(array(['status'=>"Error"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
                }
            }

        public function softdelete(Request $request){
            $queryparse=$request->urlparse;
            $parser=  app('App\Http\Controllers\UrlParseController')->queryparser($queryparse);
            $setproduct= DB::table('product')
            ->where($parser)
            ->update(['productstatus' =>5
            ]);
            if($setproduct){
                return response()->json(array(['status'=>"Deleted"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
            }else{
                return response()->json(array(['status'=>"Error"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
            }
        }

    public function add(Request $request){
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
                return response()->json(array(['status'=>"InsertedProduct",'id'=>$newproduct]), 200);
        }else{
                return response()->json(array(['status'=>"NotInserted"]), 200);
        }
    }
        public function getproductdetail(Request $request){
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
              for($i=0;$i<count($products);$i++){
                $img[] = array(
                       "data:image/jpeg:image/png;base64,".base64_encode($products[$i]->photo),
                            );
            }
            $favcount= app('App\Http\Controllers\FavProductController')->favprcount($products[0]->productid);
            $seencount= app('App\Http\Controllers\UserSeenProductController')->seencount($products[0]->productid);
            $product[] = array(
                "productid"=>$products[0]->productid,
                "title"=>$products[0]->title,
                "descraption"=>$products[0]->descraption,
                "price"=>$products[0]->price,
                "oldprice"=>$products[0]->oldprice,
                "categoryid"=>$products[0]->category,
                "categorytxt"=>$products[0]->categorytxt,
                "productstatus"=>$products[0]->productstatus,
                "status"=>$products[0]->status,
                "cityid"=>$products[0]->cityid,
                "cityname"=>$products[0]->cityname,
                "date"=>$products[0]->date,
                "time"=>$products[0]->time,
                "university"=>$products[0]->university,
                "universityname"=>$products[0]->universityname,
                "img" =>$img,
                "favcount"=>$favcount,
                "seencount"=>$seencount,
                "username"=>$products[0]->username,
                "usname"=>$products[0]->usname,
                "uslname"=>$products[0]->uslname,
                "userid"=>$products[0]->userid,
                "avatarid" => $products[0]->avatarid,
                "avatar" =>"data:image/jpeg:image/png;base64,".base64_encode($products[0]->avatar),
                        );
                        return response()->json(["data"=>$product], 200,['Content-type'=> 'application/json; charset=utf-8']);
                    }
                        else{
                            return response()->json(array(['status'=>"Not"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
                        }

                }


    public function getproduct(Request $request){
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
        for($i=0;$i<count($products);$i++){
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
        if($request->pagination=="1"){
            $product= array_slice($product, 0,10);
        }else if ($request->pagination){
            $product= array_slice($product, (10*$request->pagination)-10,10*$request->pagination);
        }

    return response()->json(["data"=>$product,"count"=>$arrcount], 200,['Content-type'=> 'application/json; charset=utf-8']);
    }else{
        return response()->json(array(['status'=>"Not"]), 200,['Content-type'=> 'application/json; charset=utf-8']);
    }
    }
}
