<?php

namespace App\Http\Controllers\seo;

use App\Http\Controllers\Controller;
use App\Models\goods;
use App\Models\posts;
use App\myappenv;
use Illuminate\Support\Facades\DB;

class sitmep extends Controller
{
    public function MainSiteMap()
    {
        $LastPorduct = goods::latest()->first();
        if ($LastPorduct != null) {
            $LastPorduct = $LastPorduct->updated_at;
        }
        $LastPost = posts::latest()->first();
        if ($LastPost != null) {
            $LastPost = $LastPost->updated_at;
        }
        $LastPage = null;


        return response()->view('seo.sitemap', ['type' => 'main', 'LastPage' => $LastPage, 'LastPost' => $LastPost, 'LastPorduct' => $LastPorduct])->header('Content-Type', 'text/xml');
    }
    public function post_sitemap()
    {
        $Posts = posts::where('Status', 1)->where('type', 1)->where('branch',myappenv::Branch)->get();
        return response()->view('seo.sitemap', ['type' => 'post', 'Posts' => $Posts])->header('Content-Type', 'text/xml');
    }
    public function cover_sitemap()
    {
        $query = "SELECT p.* , lw.Name as newscat FROM L3Work lw inner join posts p on lw.UID = p.MainIndex and p.`Type` = 3 and p.Status = 1 ";
        $Posts = DB::select($query);
        return response()->view('seo.sitemap', ['type' => 'cover', 'Posts' => $Posts])->header('Content-Type', 'text/xml');
    }
    public function page_sitemap()
    {
        $Query = "SELECT g.id,g.NameFa,g.ImgURL,wg.updated_at,g.urladdress
    from
        warehouse_goods wg
    inner join goods g on
        wg.GoodID = g.id
    INNER JOIN  goodindices g2 on g2.GoodID = wg.GoodID
        WHERE wg.OnSale = 1 ";
        $ProductSrc = DB::select($Query);
        $PreTag = myappenv::PreProductTag;
        return response()->view('seo.sitemap', ['type' => 'page', 'PreTag' => $PreTag, 'ProductSrc' => $ProductSrc])->header('Content-Type', 'text/xml');
    }
    public function product_sitemap()
    {
        $Query = "SELECT g.id,g.NameFa,g.ImgURL,wg.updated_at,g.urladdress
    from
        warehouse_goods wg
    inner join goods g on
        wg.GoodID = g.id
    INNER JOIN  goodindices g2 on g2.GoodID = wg.GoodID
        WHERE wg.OnSale = 1 ";
        $ProductSrc = DB::select($Query);
        $PreTag = myappenv::PreProductTag;
        return response()->view('seo.sitemap', ['type' => 'product', 'PreTag' => $PreTag, 'ProductSrc' => $ProductSrc])->header('Content-Type', 'text/xml');
    }
    public function deal_sitemap()
    {
        $branch = env('Branch');
        $query = "SELECT df.*  from deal_file df where df.status > 100 and branch = $branch";
        $deal_src = DB::select($query);
        $PreTag = myappenv::PreProductTag;
        return response()->view('seo.sitemap', ['type' => 'deal', 'PreTag' => $PreTag, 'deal_src' => $deal_src])->header('Content-Type', 'text/xml');
    }
    public function emalls()
    {
        $Query = "SELECT g.id ,
        g.NameFa ,
        g.MinPrice ,
        g.MaxPrice ,
        g.ImgURL ,
        g.stock_quantity ,
        g.average_rating ,
        g.total_sales ,
        g.rating_count ,
        g.MainDescription,
        g.UnitPlan,
        wg.BasePrice ,
        wg.Remian,
        wg.PricePlan,
        wg.Price ,
        wg.id as wgid
    from
        warehouse_goods wg
    inner join goods g on
        wg.GoodID = g.id
        WHERE wg.OnSale = 1 ";



        $Query = "SELECT g.id,g.SKU,g.NameFa,g.ImgURL,wg.updated_at,g.urladdress,wg.BasePrice ,wg.PricePlan,wg.Price
    from
        warehouse_goods wg
    inner join goods g on
        wg.GoodID = g.id
    INNER JOIN  goodindices g2 on g2.GoodID = wg.GoodID
        WHERE wg.OnSale = 1 ";
        $ProductSrc = DB::select($Query);
        $PreTag = myappenv::PreProductTag;
        $products = array();
        $Totall = 0;

        foreach ($ProductSrc as $ProductItem) {
            $Totall++;
            if ($ProductItem->PricePlan != null) {
                $price = \App\Http\Controllers\woocommerce\product::GetMinPrice($ProductItem->PricePlan);
                $price /= 10;
            } else {
                $price = $ProductItem->Price;
                $price /= 10;
            }
            if ($ProductItem->urladdress == null) {
                $Item = [
                    "id" => $ProductItem->id,
                    "title" => $ProductItem->NameFa,
                    "url" => route('SingleProduct', ['productID' => $PreTag . $ProductItem->id, 'productName' => $ProductItem->NameFa]),
                    "price" => $price,
                    "old_price" => null,
                    "is_available" => true
                ];
            } else {
                $Item = [
                    "id" => $ProductItem->id,
                    "title" => $ProductItem->NameFa,
                    "url" => url('/') . '/product/' . $ProductItem->urladdress,
                    "price" => $price,
                    "old_price" => null,
                    "is_available" => true
                ];
            }

            array_push($products, $Item);
        }
        $OutputArr = [
            'success' => true,
            'products' => $products,
            'total' => $Totall,
        ];
        $Outputson = json_encode($OutputArr);
        return view('seo.emalls', ['Outputson' => $Outputson]);
    }
}
