<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Item;

class ItemsController extends Controller
{
    public function create()
    {
        $keyword = request()->keyword;
        $items = [];
        if ($keyword) {
            $client = new \RakutenRws_Client();
            $client->setApplicationId(env('RAKUTEN_APPLICATION_ID'));

            $rws_response = $client->execute('BooksTotalSearch', [
                'keyword' => $keyword,
                'booksGenreId' => "001001",
                'imageFlag' => 1,
                'hits' => 30,
            ]);

            // 扱い易いように Item としてインスタンスを作成する（保存はしない）
            foreach ($rws_response->getData()['Items'] as $rws_item) {
                $item = new Item();
                $item->code = $rws_item['Item']['isbn'];
                $item->name = $rws_item['Item']['title'];
                $item->url = $rws_item['Item']['itemUrl'];
                $item->image_url = str_replace('?_ex=120x120', '', $rws_item['Item']['mediumImageUrl']);
                $items[] = $item;
            }
        }

        return view('items.create', [
            'keyword' => $keyword,
            'items' => $items,
        ]);
    }
    
    public function show($id)
    {
      $item = Item::find($id);
      $want_users = $item->want_users;
      $read_users = $item->read_users;

      return view('items.show', [
          'item' => $item,
          'want_users' => $want_users,
          'read_users' => $read_users,
      ]);
    }
}
