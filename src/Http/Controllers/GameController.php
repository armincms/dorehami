<?php 

namespace Armincms\Dorehami\Http\Controllers;
 
use Armincms\TruthOrDare\Game;
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
    public function create(Request $request)
    {
    	$game = tap(new Game, function($game) use ($request) {
            $user = $request->user() ?? \Core\User\Models\Admin::first();

            $game->forceFill([
                'user_id' => $user->getKey(),
                'user_type' => $user->getMorphClass(),
                'level' => $request->get('level'),
            ])->save(); 
        });

        return [
            'status' => 'ok',
            'game'   => $game->getGameIdentifier(),   
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
        $game = Game::whereGame($game)->firstOrFail();

         tap(new Game, function($game) use ($request) {
            $user = $request->user() ?? \Core\User\Models\Admin::first();

            $game->forceFill([
                'user_id' => $user->getKey(),
                'user_type' => $user->getMorphClass(),
                'level' => $request->get('level'),
            ])->save();

            $game->players()->sync((array) $request->get('players'));
            $game->themes()->sync((array) $request->get('themes'));
        });

        return [
            'status' => 'ok',
            'game'   => $game->getGameIdentifier(),   
        ];
    }
}
