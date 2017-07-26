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
        $data = [];
        if (\Auth::check()) {
            $user = User::find($id);
            $reviews = $user->reviews()->orderBy('created_at', 'desc')->paginate(10);
            $items = Item::orderBy('updated_at', 'desc')->paginate(20);

            $data = [
                'user' => $user,
                'reviews' => $reviews,
                'items' => $items,
            ];
            
        }
        $data += $this->counts($user);
        
        return view('users.show', $data);
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
    
    public function itemlists($id)
    {
        $user = User::find($id);
        $items = [];
        if (Item::exists()) {
            $items = \DB::table('items')->join('item_user', 'items.id', '=', 'item_user.item_id')->select('items.*')->where('item_user.user_id', $user->id)->distinct()->groupBy('items.id')->paginate(20);
        }

        $data = [
            'user' => $user,
            'items' => $items,
        ];
        
        $data += $this->counts($user);
        
        return view('users.itemlists', $data);
        
    }
}