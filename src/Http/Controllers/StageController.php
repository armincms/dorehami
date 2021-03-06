<?php 

namespace Armincms\Dorehami\Http\Controllers;
 
use Illuminate\Http\Request; 
use Armincms\RawData\Common;
use Armincms\TruthOrDare\Game;
use Armincms\TruthOrDare\Stage;
use Armincms\TruthOrDare\Player;
use Armincms\TruthOrDare\Question;
use Armincms\TruthOrDare\Consequence;
use Illuminate\Validation\Rule;

class StageController extends Controller
{  
    public function handle(Request $request, $gameId, $playerId)
    {
        $game = Game::withCount('stages')->whereGame($gameId)->first();

        if($game->stages_count >= $game->stage) {
            return response()->json([
                'message' => 'Your Game Ended',
                'data' => [
                    'stage' => 'Your Game Ended',
                ],
            ], 422);
        }

        $this->validate($request, [ 
            'questionId' => [
                'required', 
                function($attribute, $value, $fail) {
                    if(is_null(Question::find($value))) {
                        $fail("Selected Question is invalid");
                    }
                }
            ],
            'consequenceId' => [
                Rule::requiredIf(! boolval($request->passed)), 
                function($attribute, $value, $fail) use ($request) { 
                    if(! boolval($request->passed) && is_null(Consequence::find($value))){
                        $fail("The consequence is invalid");
                    }
                }
            ], 
            'passed' => 'required'
        ]);

        $stage = tap(new Stage, function($stage) use ($request, $game, $playerId) {
            $stage->forceFill([
                'player_id'   => $playerId,
                'game_id'     => $game->id, 
                'passed'      => intval($request->passed),
                'question_id' => $request->questionId, 
                'consequence_id' => $request->consequenceId, 
            ])->save();
        }); 

        return response()->json([ 
            "status" => "ok",
            "stageId" => $stage->id
        ], 201);
    }   
}
