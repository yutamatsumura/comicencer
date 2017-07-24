<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Item;

class UsersController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $count_want = $user->want_items()->count();
        $count_read = $user->read_items()->count();
        $items = [];
        if (Item::exists()) {
            $items = \DB::table('items')->join('item_user', 'items.id', '=', 'item_user.item_id')->select('items.*')->where('item_user.user_id', $user->id)->distinct()->groupBy('items.id')->paginate(20);
        }

        return view('users.show', [
            'user' => $user,
            'items' => $items,
            'count_want' => $count_want,
            'count_read' => $count_read,
        ]);
    }
    
    public function followings($id)
    {
        $user = User::find($id);
        $followings = $user->followings()->paginate(10);
        
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
        $followers = $user->followers()->paginate(10);
        
        $data = [
            'user' => $user,
            'users' => $followers,
        ];
        
        $data += $this->counts($user);
        
        return view('users.followers', $data);
    }
}