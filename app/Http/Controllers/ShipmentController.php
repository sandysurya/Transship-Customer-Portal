<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
class ShipmentController extends Controller
{
/**
     * Initialize the login action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        if($request->method == 'save'){

        if (! $shipment = $request->all()) {
            return response()->json([
                'success' => false,
                'msg' => 'Need to be authenticated.',
            ]);
        }
        $shipment['tracking_id']="TSBT".rand();
        $shipment['order_id']="TSBO".rand();
       unset($shipment['method']);

        Shipment::create($shipment);
           return response()->json([
            'success' => true,
            'msg' => 'The shipment data was successfully saved.',
        ]);
    }
    else if($request->method == 'update'){

        if (! $shipment = $request->all()) {
            return response()->json([
                'success' => false,
                'msg' => 'Need to be authenticated.',
            ]);
        }
       unset($shipment['method']);
       unset($shipment['id']);
            Shipment::where('id',$request->id)->update($shipment);
      

           return response()->json([
            'success' => true,
            'msg' => 'The shipment data was successfully updated.',
        ]);
    }
    else if($request->method == 'list'){

        $shipmentdata=Shipment::where(['user_id'=>$request->user_id,'flag'=>0])->get();

        return response()->json([
            'success' => true,
            'data'=>$shipmentdata,
            'msg' => 'The shipment data was successfully listed.',
        ]);


    }
    else if($request->method == 'dashboard'){

   
        $customers=User::where(['user_role'=>2,'id'=>$request->user_id])->get()->count();
        $users=User::where(['user_role'=>1,'id'=>$request->user_id])->get()->count();
        $neworders=Shipment::where('user_id',$request->user_id)->where('created_at','like','%'.date('Y-m-d').'%')->get()->count();
        $totalorders=Shipment::where('user_id',$request->user_id)->get()->count();
        $listorders=Shipment::where('user_id',$request->user_id)->orderBy('id','DESC')->limit(5)->get();

        return response()->json([
            'success' => true,
            'data'=>['customers'=>$customers,'users'=>$users,'neworders'=>$neworders,'totalorder'=>$totalorders,'listorders'=>$listorders],
            'msg' => 'The dashboard data was successfully listed.',
        ]);


    }
    else if($request->method == 'delete'){
        $userdeletedatas=UserDoc::find($request->id);
        $userdeletedatas->delete();
        $userdocdatas=UserDoc::get();
        return response()->json([
            'success' => true,
            'data'=>$userdocdatas,
            'msg' => 'The user document was successfully deleted.',
        ]);


    }
    
    }
    protected function failure(string $message)
    {
        return response()->json([
            'success' => false,
            'msg' => $message,
        ]);
    }
}