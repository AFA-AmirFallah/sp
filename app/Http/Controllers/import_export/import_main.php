<?php

namespace App\Http\Controllers\import_export;

use App\Http\Controllers\Controller;
use App\import_export\import_nopcommerce;
use Illuminate\Http\Request;

class import_main extends Controller
{

    public function Import()
    {

        $my_import = new import_nopcommerce('app/public/files/products_sepehrmall.xml');
        $result = $my_import->update_existing_from_backup();
        return view('import_export.import_main', ['result' => $result]);
    }
}
