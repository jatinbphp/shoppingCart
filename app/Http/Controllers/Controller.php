<?php

namespace App\Http\Controllers;

use App\Models\OrderStockHistory;
use App\Models\ProductStock;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function fileMove($photo, $path){
        $root = 'public/uploads/'.$path;
        $name = Str::random(20).".".$photo->getClientOriginalExtension();
        if (!file_exists($root)) {
            mkdir($root, 0777, true);
        }
        $photo->move($root,$name);
        return 'public/uploads/'.$path."/".$name;
    }

    public function getCategories(){
        $results = DB::table('categories')
            ->select('categories.id', 'categories.name as category_name', 'parents.name as parent_name')
            ->leftJoin('categories as parents', 'categories.parent_category_id', '=', 'parents.id')
            ->where('categories.status', 'active')
            ->orderBy('categories.name', 'ASC')
            ->get();

        // Assuming you want to transform the results into the desired format
        $results = $results->map(function ($row) {
            $row->categoryName = !empty($row->parent_name) ? $row->parent_name . " -> " . $row->category_name : $row->category_name;
            return $row;
        });

        return $results;
    }

    function getSlug($data){
        $resString = preg_replace('/[^a-zA-Z0-9_ -]/s','',$data);
        $returnString = str_replace(" ","-",strtolower($resString));
        // Returning the result
        return strtolower($returnString);
    }

    public function checkStock($pId, $oIds, $is_cart, $orderId = null, $pQty = null, $is_cancelled = null){
        $stock = ProductStock::where('product_id',$pId)
            ->where(function($query) use ($oIds) {
                $query->where('option_id_value_1', $oIds[0])
                    ->Where('option_id_value_2', $oIds[1]);
            })->orwhere(function($query) use ($oIds) {
                $query->where('option_id_value_1', $oIds[1])
                    ->Where('option_id_value_2', $oIds[0]);
            })->first();

        if($is_cart == 0){
            if(!empty($stock)){
                $inStock = [];
                $is_update = 1;
                if($is_cancelled == 1){
                    $inStock['remaining_qty'] = $stock['remaining_qty'] + $pQty;
                    $inStock['order_qty'] = $stock['order_qty'] - $pQty;
                }else{
                    if($stock['remaining_qty'] <= 0){
                        $is_update = 0;
                    }else{
                        if($stock['remaining_qty'] >= $pQty){
                            $inStock['remaining_qty'] = $stock['remaining_qty'] - $pQty;
                            $inStock['order_qty'] = $stock['order_qty'] + $pQty;
                        } else {
                            $is_update = 0;
                        }
                    }
                }
                if($is_update == 1){
                    $stock->update($inStock);

                    $inOrderStock = [];
                    $inOrderStock['order_id'] = $orderId;
                    $inOrderStock['type'] = ($is_cancelled == 1) ? 'plus' : 'minus';
                    $inOrderStock['product_id'] = $pId;
                    $inOrderStock['option_id_value_1'] = $stock['option_id_value_1'];
                    $inOrderStock['option_id_value_2'] = $stock['option_id_value_2'];
                    $inOrderStock['qty'] = $pQty;
                    OrderStockHistory::create($inOrderStock);
                    return 1;
                }else{
                    return 0;
                }
            }
        }else{
            return $stock;
        }
    }

    public function updateOrderStock()
    {

    }
}
