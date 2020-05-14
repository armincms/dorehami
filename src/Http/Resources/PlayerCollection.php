<?php 

namespace Armincms\Dorehami\Http\Resources;


use Illuminate\Http\Resources\Json\ResourceCollection;

class PlayerCollection extends ResourceCollection
{ 
    /**
     * Transform the resource into a JSON array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function($player) {
        	return [
        		'playerId' => $player->id,
        		'name'     => $player->name, 
                'age'      => $player->age, 
                'marital'  => $player->marital, 
                'gender'   => $player->gender, 
        	];
        })->all();
    }
}
