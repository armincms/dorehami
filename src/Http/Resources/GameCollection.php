<?php 

namespace Armincms\Dorehami\Http\Resources;


use Illuminate\Http\Resources\Json\ResourceCollection;

class GameCollection extends ResourceCollection
{ 
    /**
     * Transform the resource into a JSON array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function($game) {
        	return [
        		'gameId' => $game->game,
           		'level'  => 'easy',
                'stage'  => $game->stage,
           		'created_at' => $game->created_at,
           		'updated_at' => $game->updated_at,
           		'deleted_at' => $game->deleted_at, 
        	];
        })->all();
    }
}
