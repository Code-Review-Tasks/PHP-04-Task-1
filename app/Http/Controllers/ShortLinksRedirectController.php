<?php

namespace App\Http\Controllers;

use App\Models\ShortLinks;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class ShortLinksRedirectController extends Controller
{
    /**
     * @param ShortLinks $shortLinks
     * @return RedirectResponse|Application|Redirector
     */
    public function checkLink(ShortLinks $shortLinks): RedirectResponse|Application|Redirector
    {
        return redirect($shortLinks->long_url);
    }
}
