<?php 

namespace Armincms\Dorehami\Http\Controllers;
 
use Armincms\TruthOrDare\Game;
use Armincms\TruthOrDare\Theme;
use Illuminate\Http\Request;
use Armincms\Dorehami\Http\Resources\GameCollection;

class GameController extends Controller
{ 

    public function index(Request $request)
    {
        $games = Game::paginate($request->perPage ?? 15);

        return new GameCollection($games);
    }
    /**
     * Create new game.
     * 
     * @param string $game 
     * @return array
     */
    public function store(Request $request)
    {
        $this->validate($request, ['level' => 'required', 'stage' => 'required']);

    	$game = tap(new Game, function($game) use ($request) {
            $user = $request->user() ?? \Core\User\Models\Admin::first();

            $game->forceFill([
                'user_id' => $user->getKey(),
                'user_type' => $user->getMorphClass(),
                'level' => $request->get('level'),
                'stage' => intval($request->get('stage')),
            ])->save(); 
        });

        return [
            'status' => 'ok',
            'gameId'   => $game->getGameIdentifier(),   
        ];
    }

    /**
     * Create new game.
     * 
     * @param string $game 
     * @return array
     */
    public function update(Request $request, $game)
    {
        $this->validate($request, ['level' => 'required']);

        $game = Game::whereGame($game)->firstOrFail();

         tap(new Game, function($game) use ($request) {
            $user = $request->user() ?? \Core\User\Models\Admin::first();

            $game->forceFill([
                'user_id' => $user->getKey(),
                'user_type' => $user->getMorphClass(),
                'level' => $request->get('level'),
                'stage' => intval($request->get('stage')),
            ])->save(); 
        });

        return [
            'status' => 'ok',
            'gameId'   => $game->getGameIdentifier(),   
        ];
    }
}
