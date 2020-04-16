<?php 

namespace Armincms\Dorehami\Http\Controllers;
 
use Armincms\TruthOrDare\Theme;
use Illuminate\Http\Request;
use Armincms\Dorehami\Http\Resources\ThemeCollection;

class ThemeController extends Controller
{  
    public function handle(Request $request)
    {
        $games = Theme::paginate($request->perPage ?? 100);

        return new ThemeCollection($games);
    } 
}
