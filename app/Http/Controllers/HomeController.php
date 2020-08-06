<?php

namespace App\Http\Controllers;

use App\Http\Services\ChampionService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param ChampionService $championService
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, ChampionService $championService)
    {
        //
        if(!$championService->getChampions()) {
            flash()->error('Error loading newest data');
        }
        return view('welcome');
    }
}
