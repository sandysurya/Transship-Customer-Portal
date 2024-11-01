<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserInfo;
use App\Models\UserDoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class EditUserController extends Controller
{
    /**
     * Initialize the login action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        if($request->method == 'info'){
        if (! $users = $request->all()) {
            return response()->json([
                'success' => false,
                'msg' => 'Need to be authenticated.',
            ]);
        }

        // $request->validate([
        //     'username' => ['required', 'string', Rule::unique(User::class, 'username')->ignore($user->id)],
        //     'email' => ['required', 'email', Rule::unique(User::class, 'email')->ignore($user->id)],
        // ]);

        $user['name']=$request->username;
        $user['user_type']=$request->user_type;
        $userinfo['tins']=$request->tins;
        $userinfo['email']=$request->email;
        $userinfo['tin_number']=$request->tin_number;
        $userinfo['tin_cols']=$request->tin_cols;
        $userinfo['postal_code']=$request->postal_code;
        $userinfo['district']=$request->district;
        $userinfo['phone_number']=$request->phone_number;
        $userinfo['address1']=$request->address1;
        $userinfo['address2']=$request->address2;

        User::find($request->id)->update($user);
        UserInfo::where('user_id',$request->id)->update($userinfo);
        $userinfo['user_id']=$request->id;
        return response()->json([
            'success' => true,
            'data'=>$userinfo,
            'msg' => 'The user data was successfully saved.',
        ]);
    }
    else if($request->method == 'doc'){

       
        $imageName = $request->doc->getClientOriginalName();

        $request->doc->move('../react-ui/public/assets/documents', $imageName);      
        $userdoc['document_name']=$imageName;
        $userdoc['document_type']= $request->type;
        $userdoc['user_id']=$request->id;
        $userdoc['flag']=$request->flag;
        UserDoc::create($userdoc);
        $userdocdata=UserDoc::get();

        return response()->json([
            'success' => true,
            'data'=>$userdocdata,
            'msg' => 'The user document was successfully saved.',
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
    else if($request->method == 'changepassword'){
        $userdatas=User::find($request->id);
        if(Hash::check($request->current_password,$userdatas->password)) {
        $userdatas->password=Hash::make($request->new_password);
        $userdatas->save();

        return response()->json([
            'success' => true,
            'msg' => 'The user password was successfully saved.',
        ]);
        }
        else{
            return $this->failure('Current Password is incorrent.');
        }
       
       
        


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
