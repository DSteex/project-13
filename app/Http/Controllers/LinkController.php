<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\LinkClick;

class LinkController extends Controller
{
    public function redirect($code)
    {
        $link = Link::where('code', $code)->firstOrFail();

        LinkClick::create([
            'link_id' => $link->id,
            'ip_address' => request()->ip(),
        ]);

        return redirect($link->original_url);
    }
}
