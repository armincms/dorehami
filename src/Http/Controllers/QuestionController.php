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
        $game = Game::with('questions', 'themes')->whereGame($gameId)->firstOrFail(); 
        $player = Player::whereHas('games', function($q) use ($gameId) {
            $q->where($q->qualifyColumn('game'), $gameId);
        })->findOrFail($playerId); 

        $question = Question::whereTruth(intval($request->truth))
                            ->where('level', $game->level)
                            ->whereNotIn('id', $game->questions->modelKeys())
                            ->whereIn('theme_id', $game->themes->modelKeys())
                            ->gender($player->gender)
                            ->marital($player->marital)
                            ->age($player->age) 
                            ->inRandomOrder() 
                            ->firstOrFail();

        return response()->json([ 
            "questionId" => $question->id,
            "question" => $question->question,
        ], 200);
    }    
}
