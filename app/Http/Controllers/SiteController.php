<?php

namespace App\Http\Controllers;

use App\Models\TextWidget;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SiteController extends Controller
{
    public function about()
    {
        $about = TextWidget::query()
            ->where('key', '=', 'about-us')
            ->where('active', '=', true)
            ->first();

        if (!$about) {
            throw new NotFoundHttpException();
        }
        return view('about', compact('about'));
    }
}
