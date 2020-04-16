<?php 

namespace Armincms\Dorehami\Http\Controllers;
 
use Illuminate\Http\Request;  
use Armincms\TruthOrDare\Game; 
use Armincms\TruthOrDare\Player; 
use Armincms\TruthOrDare\Question; 

class QuestionController extends Controller
{  
    public function handle(Request $request, $gameId, $playerId)
    { 
        $game = Game::with('questions', 'themes')->findOrFail($gameId); 
        $player = Player::where('game_id', $gameId)->findOrFail($playerId); 

        $question = Question::whereTruth(intval($request->truth))
                            ->where('level', $game->level)
                            ->whereNotIn('id', $game->questions->modelKeys())
                            ->whereIn('theme_id', $game->themes->modelKeys())
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
            "questionId" => $question->id,
            "question" => $question->question,
        ], 200);
    }    
}
