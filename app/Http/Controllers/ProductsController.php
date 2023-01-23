<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Allcateg;
use App\Models\Allproducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\detailsResource;
use App\Http\Resources\categoryResource;
use App\Http\Resources\allproductsResource;
use Carbon\Carbon;
use Nette\Utils\Json;

class ProductsController extends Controller
{

    public function  all_products()
    {

        return allproductsResource::collection(DB::table('allproducts')
            ->select('allproducts.id', 'allproducts.title', 'allproducts.price', 'allproducts.image')
            ->get());
    }

    public function categories()
    {

        return categoryResource::collection(Allcateg::all());
    }

    public function categories_items(Request $request)
    {
        $category = $request->category_id;

        if ($category == '1') {
            return $this->all_products();
        } else {
            return allproductsResource::collection(DB::table('allproducts')
                ->leftJoin('allcategs', 'allcategs.id', '=', 'allproducts.allcategs_id')
                ->select('allproducts.id', 'allproducts.title', 'allproducts.price', 'allproducts.image', 'allcategs.category')
                ->where('allproducts.allcategs_id', '=', $category)
                ->get());
        }
    }

    public function prod_details(Request $request)
    {
        $prod_id = $request->prod_id;
        return detailsResource::collection(DB::table('allproducts')
            ->leftJoin('allcategs', 'allcategs.id', '=', 'allproducts.allcategs_id')
            ->select('allcategs.category', 'allproducts.id', 'allproducts.image', 'allproducts.title', 'allproducts.description', 'allproducts.price')
            ->where('allproducts.id', '=', $prod_id)
            ->get());
    }

    public function find_product(Request $request)
    {

        $input = $request->uinput;


        $query = DB::table('allproducts')
            ->leftJoin('allcategs', 'allcategs.id', '=', 'allproducts.allcategs_id')
            ->select('allproducts.id', 'allproducts.title', 'allproducts.price', 'allproducts.image', 'allcategs.category')
            ->where('allproducts.title', 'LIKE', '%' . $input . '%')
            ->orWhere('allcategs.category', 'LIKE', '%' . $input . '%')
            ->get();

        return allproductsResource::collection($query);
    }


}
