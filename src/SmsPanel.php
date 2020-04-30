<?php

namespace Armincms\Dorehami;

use Armincms\Bios\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;  

class SmsPanel extends Resource
{ 
    /**
     * The option storage driver name.
     *
     * @var string
     */
    public static $store = '';

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Text::make('Username')
                ->required()
                ->rules('required'),

            Text::make('Password')
                ->required()
                ->rules('required'),

            Text::make('Number')
                ->required()
                ->rules('required'),
        ];
    }
}
