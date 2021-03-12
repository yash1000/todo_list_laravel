<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Item;

class ItemController extends Controller
{
    public function index()
    {
      return Item::orderBy('created_at','ASC')->get();
    }

    public function store(Request $request)
   {
       $validated = $request->validate([
           'item' => 'required',
           'item.name' => 'required',
       ]);

            $newItem = new Item;
            $newItem->name = $request->item['name'];
            $newItem->save();
            return $newItem;
    }


    public function update(Request $request, int $id)
    {
        $existingItem = Item::find( $id );
        if( $existingItem ){
            $existingItem->completed = $request->item['completed'] ? true : false ;
            $existingItem->completed_at = $request->item['completed'] ? Carbon::now() : null ;
            $existingItem->save();
            return $existingItem;
        } else {
            return 'No item found.';
        }
    }


    public function destroy(int $id)
    {
        $existingItem = Item::find( $id );
        if( $existingItem ){
            $existingItem->delete();
            return 'Item deleted succesfully';
        } else {
            return 'No item found.';
        }
    }
}
