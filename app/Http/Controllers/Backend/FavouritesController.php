<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\Reply;
use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FavouritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
    * Store a new favourite in the database.
    *
    *@param Reply $reply
    *@return \Illuminate\Database\Eloquent\Model
    */
    public function store(Reply $reply)
    {
        $reply->favourite();

        if (request()->expectsJson())
            return response(['status' => 'Favourited successfully!']);

        return back();
    }

    public function destroy(Reply $reply)
    {
        $reply->unfavourite();
    }
}
