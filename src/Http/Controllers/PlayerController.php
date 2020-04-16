<?php 

namespace Armincms\Dorehami\Http\Controllers;
 
use Armincms\TruthOrDare\Player;
use Armincms\TruthOrDare\Game;
use Illuminate\Http\Request; 
use Armincms\RawData\Common;

class PlayerController extends Controller
{  
    public function create(Request $request)
    {
        $this->validate($request, array_map(function($rules) {
            $rules[] = 'required';

            return $rules;
        }, $this->rules()));

        $player = tap(new Player, function($player) use ($request) {
            $player->forceFill($this->fetchData($request))->save();
        }); 

        return response()->json([ 
            "status" => "ok",
            "playerId" => $player->id
        ], 201);
    } 

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rules());

        $player = tap(Player::findOrFail($id), function($player) use ($request) {
            $player->forceFill(array_filter($this->fetchData($request)))->save();  
        });

        return response()->json([ 
            "status" => "ok",
            "playerId" => $player->id
        ], 200);
    } 

    public function fetchData(Request $request)
    {
        return [
            'game_id' => $request->gameId,
            'age' => $request->age,
            'marital' => $request->marital,
            'gender' => $request->gender,
            'name' => $request->name,
        ];
    }

    public function rules()
    {
        return [
            'gameId' =>  function ($attribute, $value, $fail) {
                if (is_null(Game::find($value))) {
                    $fail('Game ID is invalid.');
                }
            },
            'name' => [ 
            ],
            'age' => [
                'in:'. Common::ages()->keys()->implode(','),
            ],
            'marital' => [
                'in:'. Common::maritals()->keys()->implode(','),
            ],
            'gender' => [
                'in:'. Common::genders()->keys()->implode(','),
            ],
        ];
    }
}
