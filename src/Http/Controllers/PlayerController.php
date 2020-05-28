<?php 

namespace Armincms\Dorehami\Http\Controllers;
 
use Armincms\Dorehami\Http\Resources\PlayerCollection;
use Armincms\TruthOrDare\Player;
use Armincms\TruthOrDare\Game;
use Illuminate\Http\Request; 
use Armincms\RawData\Common;

class PlayerController extends Controller
{  
    public function index(Request $request)
    {
        $games = Player::authenticate($request->user())->paginate($request->perPage ?? 100);

        return new PlayerCollection($games);
    }  

    public function store(Request $request)
    {
        $this->validate($request, array_map(function($rules) {
            if(is_array($rules)) {
                $rules[] = 'required';
            } 

            return $rules;
        }, $this->rules()));

        $player = tap(new Player, function($player) use ($request) {
            $player->forceFill($this->fetchData($request))->save();
        }); 

        return $this->okResponse($player->id, 201);
    } 

    public function show(Request $request, $playerId)
    { 
        $player = Player::findOrFail($playerId);

        return [
            'playerId' => $player->id, 
            'name'     => $player->name, 
            'marital'  => $player->marital, 
            'gender'   => $player->gender, 
            'age'      => $player->geagender,
        ];
    } 

    public function update(Request $request, $id)
    { 
        $player = tap(Player::findOrFail($id), function($player) use ($request) {
            $player->forceFill(array_filter($this->fetchData($request)))->save();  
        });
 
        return $this->okResponse($player->id);
    } 

    public function destroy(Request $request, $playerId)
    {
        Player::findOrFail($playerId)->delete();

        return $this->okResponse($playerId, 204);
    }

    public function okResponse($playerId, $status = 200)
    { 
        return response()->json([ 
            "status" => "ok",
            "playerId" => $playerId
        ], $status);
    }

    public function fetchData(Request $request)
    {
        return [ 
            'age' => $request->age,
            'marital' => $request->marital,
            'gender' => $request->gender,
            'name' => $request->name,
        ];
    }

    public function rules()
    {
        return [ 
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
