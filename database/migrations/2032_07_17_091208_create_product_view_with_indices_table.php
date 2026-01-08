<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductViewWithIndicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE
   ALGORITHM = UNDEFINED
   VIEW `product_view_with_indices` AS 
   SELECT
        g.id ,
        g.NameFa ,
        wg.MinPrice ,
        wg.MaxPrice ,
        wg.extra,
        g.ImgURL ,
        g.IRID,
        g.SKU,
        g.stock_quantity ,
        g.average_rating ,
        g.total_sales ,
        g.UnitPlan,
        wg.BasePrice ,
        g.rating_count ,
        g.MainDescription,
        wg.PricePlan,
        wg.Remian,
        wg.Price ,
        wg.view ,
        wg.id as wgid,
        L3.img,
        L3.L1ID,
        L3.L2ID,
        L3.L3ID,
        L3.WorkCat,
        g2.IndexID,
        g.Virtual
    from
        warehouse_goods wg
    inner join goods g on
        wg.GoodID = g.id
    INNER JOIN  goodindices g2 on g2.GoodID = wg.GoodID INNER JOIN L3Work  L3 on L3.UID =  g2.IndexID
        WHERE wg.OnSale = 1 ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_view_with_indices');
    }
}
