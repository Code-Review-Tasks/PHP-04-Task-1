<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortLink;
use Illuminate\Support\Str;

class ShortLinkController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function index()
    {
        return view('shortlinks', [
            'shortlinks'=> ShortLink::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'link'=>'required|url'
        ]);

        ShortLink::create([
            'link'=> $request->link,
            'code' => str_random(6)
        ]);
        return redirect()->route('generate-link')->with('success', 'Короткая ссылка успешно  создана');
    }

    public function shortLink($code)
    {
        $link = ShortLink::where('code', $code)->first();
        $link->count++;
        $link->save();

        return redirect($link->link);

    }

    public function deleteLink(ShortLink $link){
        $link->delete();

        return redirect()->back();
    }
}
