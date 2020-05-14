<?php 

namespace Armincms\Dorehami\Http\Controllers;
  
use Armincms\TruthOrDare\Player;
use Armincms\TruthOrDare\Theme;
use Armincms\TruthOrDare\Game;
use Illuminate\Http\Request;

class AttachController extends Controller
{    
    public function theme(Request $request, $game, $theme)
    { 
        Game::whereGame($game)->firstOrFail()->themes()->syncWithoutDetaching(
            Theme::findOrFail($theme)
        );

        return response()->json([
            'status' => 'ok',  
        ], 201);
    }

    public function player(Request $request, $game, $player)
    { 
        Game::whereGame($game)->firstOrFail()->players()->syncWithoutDetaching(
            Player::findOrFail($player)
        );

        return response()->json([
            'status' => 'ok',  
        ], 201);
    } 
}
