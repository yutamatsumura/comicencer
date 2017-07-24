<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Item;

class ItemUserController extends Controller
{
    public function want()
    {
        $itemCode = request()->itemCode;

        // itemCode から商品を検索
        $client = new \RakutenRws_Client();
        $client->setApplicationId(env('RAKUTEN_APPLICATION_ID'));
        $rws_response = $client->execute('BooksTotalSearch', [
            'isbnjan' => $itemCode,
        ]);
        $rws_item = $rws_response->getData()['Items'][0]['Item'];

        // Item 保存 or 検索（見つかると作成せずにそのインスタンスを取得する）
        $item = Item::firstOrCreate([
            'code' => $rws_item['isbn'],
            'name' => $rws_item['title'],
            'url' => $rws_item['itemUrl'],
            // 画像の URL の最後に ?_ex=120x120 とついてサイズが決められてしまうので取り除く
            'image_url' => str_replace('?_ex=120x120', '', $rws_item['mediumImageUrl']),
        ]);

        \Auth::user()->want($item->id);

        return redirect()->back();
    }

    public function dont_want()
    {
        $itemCode = request()->itemCode;

        if (\Auth::user()->is_wanting($itemCode)) {
            $itemId = Item::where('code', $itemCode)->first()->id;
            \Auth::user()->dont_want($itemId);
        }
        return redirect()->back();
    }
    
    public function read()
    {
        $itemCode = request()->itemCode;

        // itemCode から商品を検索
        $client = new \RakutenRws_Client();
        $client->setApplicationId(env('RAKUTEN_APPLICATION_ID'));
        $rws_response = $client->execute('BooksTotalSearch', [
            'isbnjan' => $itemCode,
        ]);
        $rws_item = $rws_response->getData()['Items'][0]['Item'];

        // Item 保存 or 検索（見つかると作成せずにそのインスタンスを取得する）
        $item = Item::firstOrCreate([
            'code' => $rws_item['isbn'],
            'name' => $rws_item['title'],
            'url' => $rws_item['itemUrl'],
            // 画像の URL の最後に ?_ex=128x128 とついてサイズが決められてしまうので取り除く
            'image_url' => str_replace('?_ex=120x120', '', $rws_item['mediumImageUrl']),
        ]);

        \Auth::user()->read($item->id);

        return redirect()->back();
    }

    public function dont_read()
    {
        $itemCode = request()->itemCode;

        if (\Auth::user()->is_reading($itemCode)) {
            $itemId = Item::where('code', $itemCode)->first()->id;
            \Auth::user()->dont_read($itemId);
        }
        return redirect()->back();
    }
}