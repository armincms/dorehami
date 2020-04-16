<?php 

namespace Armincms\Dorehami\Http\Resources;


use Illuminate\Http\Resources\Json\ResourceCollection;

class ThemeCollection extends ResourceCollection
{ 
    /**
     * Transform the resource into a JSON array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function($theme) {
        	return [
        		'themeId' => $theme->id,
        		'label'   => $theme->label, 
        	];
        })->all();
    }
}
