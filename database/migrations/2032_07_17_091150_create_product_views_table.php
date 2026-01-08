<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductViewsTable extends Migration
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
   VIEW `product_views` AS 
SELECT g.id ,
   g.NameFa ,
   wg.MinPrice ,
   wg.MaxPrice ,
   wg.extra,
   g.SKU,
   g.IRID,
   g.ImgURL,
   g.stock_quantity ,
   g.average_rating ,
   g.total_sales ,
   g.rating_count ,
   g.MainDescription,
   g.UnitPlan,
   g.Description,
   g.weight,
   g.tax_status,
   wg.BasePrice ,
   g.Unit ,
   pum.Name  as unit_name,
   wg.Remian,
   wg.PricePlan,
   wg.Price ,
   wg.view ,
   wg.id as wgid ,
   wg.created_at as wg_create,
   wg.updated_at as wg_update,
   g.Virtual
from
   warehouse_goods wg
inner join goods g on
   wg.GoodID = g.id
   INNER  JOIN product_unit_metas pum on g.Unit = pum.id 
   WHERE wg.OnSale = 1 ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_views');
    }
}
