<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        return $this->simplePage('store.pages.about', 'Giới thiệu');
    }

    private function simplePage(string $view, string $title): View
    {
        return view($view, compact('title'));
    }
}
