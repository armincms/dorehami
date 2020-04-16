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
        $game = Game::with('themes')->findOrFail($gameId); 
        $player = Player::where('game_id', $gameId)->findOrFail($playerId); 

        $consequence = Consequence::wherePunishment(intval($request->punishment)) 
                            ->whereHas('themes', function($q) use ($game) {
                                $q->whereIn($q->qualifyColumn('id'), $game->themes->modelKeys());
                            })
                            ->where(function($q) use ($game) {
                                $q->whereNull('level')->orWhere("level", 'like', "%{$game->level}%");
                            })
                            ->where(function($q) use ($player) {
                                $q->whereNull('gender')->orWhere("gender", 'like', "%{$player->gender}%");
                            })
                            ->where(function($q) use ($player) {
                                $q->whereNull('marital')->orWhere("marital", 'like', "%{$player->marital}%");
                            })
                            ->where(function($q) use ($player) {
                                $q->whereNull('age')->orWhere("age", 'like', "%{$player->age}%");
                            }) 
                            ->inRandomOrder() 
                            ->firstOrFail();

        return response()->json([ 
            "consequenceId" => $consequence->id,
            "consequence" => $consequence->consequence,
        ], 200);
    }    
}
