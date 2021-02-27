<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User; //追記

class UsersController extends Controller
{

    public function index()
    {
        $users = User::orderBy('id','desc')->paginate(9);

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

}

//$users = orderBy('id','desc')は「すべてのユーザをＩＤが新しい順（降順）に並び替える」
//paginate(9)は「９名のユーザを取得する」