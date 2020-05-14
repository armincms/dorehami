<?php 

namespace Armincms\Dorehami\Http\Controllers;
 
use Illuminate\Http\Request;  
use Armincms\TruthOrDare\Game; 
use Armincms\TruthOrDare\Player; 
use Armincms\TruthOrDare\Consequence; 

class ConsequenceController extends Controller
{    
    public function handle(Request $request, $gameId, $playerId)
    { 
        $game = Game::with('themes')->whereGame($gameId)->firstOrFail(); 
        $player = Player::whereHas('games', function($q) use ($gameId) {
            $q->where($q->qualifyColumn('game'), $gameId);
        })->findOrFail($playerId); 

        $consequence = Consequence::wherePunishment(intval($request->punishment)) 
                            ->whereHas('themes', function($q) use ($game) {
                                $q->whereIn($q->qualifyColumn('id'), $game->themes->modelKeys());
                            })
                            ->where(function($q) use ($game) {
                                $q->whereNull('level')->orWhere("level", 'like', "%{$game->level}%");
                            })
                            ->gender($player->gender)
                            ->marital($player->marital)
                            ->age($player->age) 
                            ->inRandomOrder() 
                            ->firstOrFail();

        return response()->json([ 
            "consequenceId" => $consequence->id,
            "consequence" => $consequence->consequence,
        ], 200);
    }    
}
