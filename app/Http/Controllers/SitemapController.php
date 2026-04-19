<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $content = view('sitemap')->render();

        return response($content, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}
