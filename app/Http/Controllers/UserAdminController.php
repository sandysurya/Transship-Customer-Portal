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

class UserAdminController extends Controller
{
    /**
     * Initialize the login action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        if($request->method == 'add'){
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

      
        $user['username']=$request->username;
        $user['email']=$request->email;
        $user['password']=$request->password;
        $user['user_type']=$request->user_type;
        $user['name']=$request->username;

       
        if (User::whereUsername($request->username)->exists()) {
            return $this->failure('Username already taken.');
        }

        if (User::whereEmail($request->email)->exists()) {
            return $this->failure('E-Mail already taken.');
        }

        $user = User::create(array_merge($user, [
            'password' => Hash::make($request->password),
        ]));

        $doc=json_decode($request->doc);
       for($i=0;$i<count($doc);$i++){
      
        $userdoc['document_name']=$doc[$i]->document_name;
        $userdoc['document_type']= $doc[$i]->document_type;
        $userdoc['user_id']=$user->id;
        $userdoc['flag']=$doc[$i]->flag;
        UserDoc::create($userdoc);
        }

        $userinfo['email']=$request->email;
        $userinfo['tins']=$request->tins;
        $userinfo['tin_number']=$request->tin_number;
        $userinfo['tin_cols']=$request->tin_cols;
        $userinfo['postal_code']=$request->postal_code;
        $userinfo['district']=$request->district;
        $userinfo['phone_number']=$request->phone_number;
        $userinfo['address1']=$request->address1;
        $userinfo['address2']=$request->address2;
        $userinfo['user_id']=$user->id;

        UserInfo::create($userinfo);
        return response()->json([
            'success' => true,
            'data'=>$userinfo,
            'msg' => 'The customer data was successfully saved.',
        ]);
    }
    else if($request->method == 'edit'){
     
    
        $user['user_type']=$request->user_type;
        $user['name']=$request->username;

        if($request->password){
            $user['password']=Hash::make($request->password);
       }
      
        $user = User::where('id',$request->user_id)->update($user);

        $doc=json_decode($request->doc);
        $uc=UserDoc::where('user_id',$request->user_id)->delete();
       for($i=0;$i<count($doc);$i++){
      
        $userdoc['document_name']=$doc[$i]->document_name;
        $userdoc['document_type']= $doc[$i]->document_type;
        $userdoc['user_id']=$request->user_id;
        $userdoc['flag']=$doc[$i]->flag;
        UserDoc::create($userdoc);
     
        }

        $userinfo['tins']=$request->tins;
        $userinfo['tin_number']=$request->tin_number;
        $userinfo['tin_cols']=$request->tin_cols;
        $userinfo['postal_code']=$request->postal_code;
        $userinfo['district']=$request->district;
        $userinfo['phone_number']=$request->phone_number;
        $userinfo['address1']=$request->address1;
        $userinfo['address2']=$request->address2;

        UserInfo::where('user_id',$request->user_id)->update($userinfo);
        return response()->json([
            'success' => true,
            'data'=>$userinfo,
            'msg' => 'The customer data was successfully saved.',
        ]);
    }
    else if($request->method == 'useredit'){
     
        if (User::whereUsername($request->username)->exists()) {
            return $this->failure('Username already taken.');
        }

        if (User::whereEmail($request->email)->exists()) {
            return $this->failure('E-Mail already taken.');
        }

        $user['name']=$request->username;
        $user['email']=$request->email;
        $user = User::where('id',$request->id)->update($user);

        $userinfo['postal_code']=$request->postal_code;
        $userinfo['district']=$request->district;
        $userinfo['phone_number']=$request->phone_number;
        $userinfo['address1']=$request->address1;
        $userinfo['address2']=$request->address2;

        UserInfo::where('user_id',$request->id)->update($userinfo);
        return response()->json([
            'success' => true,
            'data'=>$userinfo,
            'msg' => 'The user data was successfully saved.',
        ]);
    }
    else if($request->method == 'usernew'){
     
     if (User::whereUsername($request->username)->exists()) {
            return $this->failure('Username already taken.');
        }

        if (User::whereEmail($request->email)->exists()) {
            return $this->failure('E-Mail already taken.');
        }

        $user['name']=$request->username;
        $user['username']=$request->username;
        $user['email']=$request->email;
        $user['password']=Hash::make($request->password);
        $user['user_role']=1;
        $user['user_type']="Admin";
        $user = User::create($user);

        $userinfo['email']=$request->email;
        $userinfo['postal_code']=$request->postal_code;
        $userinfo['district']=$request->district;
        $userinfo['phone_number']=$request->phone_number;
        $userinfo['address1']=$request->address1;
        $userinfo['address2']=$request->address2;
        $userinfo['user_id']=$user->id;
        UserInfo::create($userinfo);
        return response()->json([
            'success' => true,
            'data'=>$user,
            'msg' => 'The user data was successfully saved.',
        ]);
    }
    else if($request->method == 'doc'){

       
        $imageName = $request->doc->getClientOriginalName();

        $request->doc->move('../react-ui/public/assets/documents', $imageName);      
        $userdoc['document_name']=$imageName;
        $userdoc['document_type']=$request->document_type;
        $userdoc['user_id']=$request->user_id;
        $userdoc['flag']=0;
        UserDoc::create($userdoc);
        return response()->json([
            'success' => true,
            'data'=>$userdoc,
            'msg' => 'The customer document was successfully saved.',
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
    else if($request->method == 'customerlist'){

       
        $customerdata=User::where(['user_role'=>'2'])
        ->with("userinfo")
        ->with("userdoc")
        // ->join('users_info', 'users_info.user_id', '=', 'users.id')
        // ->leftjoin('users_info', 'users_info.user_id', '=', 'users.id')
        ->get();

        return response()->json([
            'success' => true,
            'data'=>$customerdata,
            'msg' => 'The customers data was successfully listed.',
        ]);


    }
   
    else if($request->method == 'dashboard'){

   $userid=$request->user_id;
        $neworders=Shipment::where('user_id',$userid)->where('created_at','like','%'.date('Y-m-d').'%')->get()->count();
        $totalorders=Shipment::where('user_id',$userid)->get()->count();
        $listorders=Shipment::where('user_id',$userid)->orderBy('id','DESC')->limit(5)->get();

        return response()->json([
            'success' => true,
            'data'=>['neworders'=>$neworders,'totalorder'=>$totalorders,'listorders'=>$listorders],
            'msg' => 'The dashboard data was successfully listed.',
        ]);


    }
    else if($request->method == 'userlist'){

        $customerdata=User::where(['user_role'=>'1'])
        ->with("userinfo")
        ->get();

        return response()->json([
            'success' => true,
            'data'=>$customerdata,
            'msg' => 'The customers data was successfully listed.',
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
