<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;

use App\User; //追記

class UsersController extends Controller
{

    public function index()
    {
        $users = User::orderBy('id','desc')->paginate(9);
//$users = orderBy('id','desc')は「すべてのユーザをＩＤが新しい順（降順）に並び替える」
//paginate(9)は「９名のユーザを取得する」

        return view('welcome', [
            'users' => $users,
        ]);
    }

    public function show($id)
    {
        $user = User::find($id);
        $movies = $user->movies()->orderBy('id', 'desc')->paginate(9);

        $data=[
            'user' => $user,
            'movies' => $movies,
        ];

        $data += $this->counts($user);

        return view('users.show',$data);
    }
    
    public function rename(Request $request)
    {
        $this->validate($request,[
                'channel' => 'required|max:15',
                'name' => 'required|max:15',
        ]);

        $user=\Auth::user();
        $movies = $user->movies()->orderBy('id', 'desc')->paginate(9);

        $user->channel = $request->channel;
        $user->name = $request->name;
        $user->save();
        
        $data=[
            'user' => $user,
            'movies' => $movies,
        ];
        
        $data += $this->counts($user);

        return view('users.show',$data);
    }
    
    public function followings($id)
    {
        $user = User::find($id);
        $followings = $user->followings()->paginate(9);

        $data = [
            'user' => $user,
            'users' => $followings,
        ];

        $data += $this->counts($user);

        return view('users.followings', $data);
    }

    public function followers($id)
    {
        $user = User::find($id);
        $followers = $user->followers()->paginate(9);

        $data = [
            'user' => $user,
            'users' => $followers,
        ];

        $data += $this->counts($user);

        return view('users.followers', $data);
    }
    
    public function destroy($id)
    {
        $user = User::find($id);
        //dd($user);
        $user->delete();
        return redirect('/');
    }
    
    public function confirm($id)
    {
        return view('users.delete_confirm');
    }
    
    public function editPassword(){
        return view('users.user_password_edit');
    }

    public function updatePassword(UpdatePasswordRequest $request){
        $user = \Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with('update_password_success', 'パスワードを変更しました。');
    }
}