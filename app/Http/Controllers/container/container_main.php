<?php

namespace App\Http\Controllers\container;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class container_main extends Controller
{
    private function truck_register(Request $request)
    {
        return  view('Layouts.Theme6.objects.container_truck_register')->render() ;

    }
    private function ajax_call(Request $request)
    {
        if (!$request->has('type')) {
            return abort('404', 'error 234231');
        }
        $type = $request->type;
        switch ($type) {
            case 'truck_register':
                return $this->truck_register($request);

            default:
                return 'function is not define => ' . $type;
        }

    }

    public function container(Request $request)
    {
        if ($request->ajax()) {
            return $this->ajax_call($request);
        }

    }
}
