<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Item;

class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $reviews = $user->feed_reviews()->orderBy('created_at', 'desc')->paginate(10);
            $items = Item::orderBy('updated_at', 'desc')->paginate(20);

            $data = [
                'user' => $user,
                'reviews' => $reviews,
                'items' => $items,
            ];
        }
        
        
        return view('welcome',$data);
    }
}