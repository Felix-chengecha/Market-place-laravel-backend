<?php

namespace App\Http\Controllers;

use App\Http\Resources\allproductsResource;
use App\Http\Resources\categoryResource;
use App\Http\Resources\detailsResource;
use App\Models\Allcateg;
use App\Models\Allproducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{

 public function  all_products(){

  return allproductsResource::collection(DB::table('allproducts')
                ->select('allproducts.id', 'allproducts.title','allproducts.price','allproducts.image')
                ->get() );
    }

  public function categories(){

    return categoryResource::collection(Allcateg::all());
  }

  public function categories_items(Request $request){
    $category=$request->category_id;

       if($category=='1'){
            return $this->all_products();
        }
        else{
        return allproductsResource::collection(DB::table('allproducts')
                    ->leftJoin('allcategs', 'allcategs.id', '=', 'allproducts.allcategs_id')
                    ->select('allproducts.id', 'allproducts.title','allproducts.price','allproducts.image','allcategs.category')
                    ->where('allproducts.allcategs_id', '=', $category)
                    ->get() );
        }
  }

  public function prod_details(Request $request){
      $prod_id=$request->prod_id;
    return detailsResource::collection(DB::table('allproducts')
            ->leftJoin('allcategs', 'allcategs.id', '=', 'allproducts.allcategs_id')
            ->select( 'allcategs.category', 'allproducts.id', 'allproducts.image', 'allproducts.title','allproducts.description','allproducts.price')
            ->where('allproducts.id', '=', $prod_id)
            ->get() );
  }

  public function find_product(Request $request){

    $input=$request->uinput;


        $query=DB::table('allproducts')
                ->leftJoin('allcategs', 'allcategs.id', '=', 'allproducts.allcategs_id')
                ->select('allproducts.id', 'allproducts.title','allproducts.price','allproducts.image','allcategs.category')
                ->where('allproducts.title', 'LIKE', '%' .$input. '%')
                ->orWhere('allcategs.category', 'LIKE', '%' .$input. '%')
                ->get();

                    return allproductsResource::collection($query);
        }


   public function paydetails(Request $request){
    $data=[
        'BusinessShortCode'=> 174379,
        'Password'=> "MTc0Mzc5YmZiMjc5ZjlhYTliZGJjZjE1OGU5N2RkNzFhNDY3Y2QyZTBjODkzMDU5YjEwZjc4ZTZiNzJhZGExZWQyYzkxOTIwMjMwMTIxMjIzMjM0",
        'Timestamp'=> "20230121223234",
        'TransactionType'=> "CustomerPayBillOnline",
        'Amount'=> 1,
        'PartyA'=> 254705384479,
        'PartyB'=> 174379,
        'PhoneNumber'=> 254705384479,
        'CallBackURL'=> "https://mydomain.com/path",
        'AccountReference'=> "CompanyXLTD",
        'TransactionDesc'=> "Payment of X"
    ];

    $info=json_encode($data);

    return $info;
   }

   public function payment(Request $request){

    $ch = curl_init('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer NQ22hvCzI4T4T9UGQZWmMVa77ian',
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$this->paydetails($request));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response     = curl_exec($ch);
    curl_close($ch);
    echo $response;

   }


//    $data= [
//     'amount' =>$amount,
//     'msisdn' =>$phone,
//     'account_no' =>$account
// ];

}
