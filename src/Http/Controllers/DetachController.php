<?php 

namespace Armincms\Dorehami\Http\Controllers;
 
use Armincms\TruthOrDare\Player;
use Armincms\TruthOrDare\Theme;
use Armincms\TruthOrDare\Game;
use Illuminate\Http\Request;

class DetachController extends Controller
{   
    public function theme(Request $request, $game, $theme)
    { 
        Game::whereGame($game)->firstOrFail()->themes()->detach(
            Theme::findOrFail($theme)
        );

        return response()->json([
            'status' => 'ok',  
        ], 200);
    }

    public function player(Request $request, $game, $player)
    { 
        Game::whereGame($game)->firstOrFail()->players()->detach(
            Player::findOrFail($player)
        );

        return response()->json([
            'status' => 'ok',  
        ], 200);
    } 
}
