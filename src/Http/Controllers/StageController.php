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
    public function create(Request $request)
    {
        $this->validate($request, [
            'gameId' => [
                'required', function($attribute, $value, $fail) {
                    if(is_null(Game::find($value))) {
                        $fail("Selected Game is invalid");
                    }
                }
            ],
            'playerId' => [
                'required', function($attribute, $value, $fail) {
                    if(is_null(Player::find($value))) {
                        $fail("Selected Player is invalid");
                    }
                }
            ],
            'questionId' => [
                'required', function($attribute, $value, $fail) {
                    if(is_null(Question::find($value))) {
                        $fail("Selected Question is invalid");
                    }
                }
            ],
            'stage' => [
                'required', function($attribute, $value, $fail) use ($request) {
                    $similar = Stage::where([
                        'game_id' => $request->gameId, 'stage' => $request->stage
                    ])->count();

                    if($similar > 0) {
                        $fail("The stage number is invalid.");
                    }
                }
            ],
        ]);

        $stage = tap(new Stage, function($stage) use ($request) {
            $stage->forceFill([
                'game_id' => $request->gameId,
                'stage' => $request->stage,
                'player_id' => $request->playerId,
                'question_id' => $request->questionId, 
            ])->save();
        }); 

        return response()->json([ 
            "status" => "ok",
            "stageId" => $stage->id
        ], 201);
    } 

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'passed' => 'required', 
            'consequenceId' => [
                Rule::requiredIf(! boolval($request->passed)), 
                function($attribute, $value, $fail) use ($request) { 
                    if(! boolval($request->passed) && is_null(Consequence::find($value))){
                        $fail("The consequence is invalid");
                    }
            }],
        ]);

        $stage = tap(Stage::findOrFail($id), function($stage) use ($request) {
            $stage->forceFill([
                'consequence_id' => $request->consequenceId,
                'passed' => $request->passed,
            ])->save();  
        });

        return response()->json([ 
            "status" => "ok",
            "stageId" => $stage->id
        ], 200);
    }  
}
