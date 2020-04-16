<?php 

namespace Armincms\Dorehami\Http\Controllers;
 
use Armincms\TruthOrDare\Game;
use Illuminate\Http\Request;
use Armincms\RawData\Common;


class SchemaController extends Controller
{ 
    /**
     * Create new game.
     *  
     * @return array
     */
    public function handle(Request $request)
    {
        return response()->json([ 
            'theme' => [
                'index' => [
                    'method' => 'get',
                    'path'   => 'dorehami/theme',
                    'params' => [
                        'per_page' => [
                            'type' => 'integer',
                            'default' => 15,
                            'required' => false,
                        ],
                        'page' => [
                            'type' => 'integer',
                            'default' => 1,
                            'required' => false,
                        ],
                    ],
                    'response' => [ 
                        'code'  => 200,
                        'params' => [ 
                            'links' => [
                                'first' => [
                                    'type' => 'string',
                                    'nullable' => true,
                                ],
                                'last' => [
                                    'type' => 'string',
                                    'nullable' => true,
                                ],
                                'prev' => [
                                    'type' => 'string',
                                    'nullable' => true,
                                ],
                                'next' => [
                                    'type' => 'string',
                                    'nullable' => true,
                                ],
                            ], 
                            'meta' => [
                                'current_page' => [
                                    'type' => 'integer'
                                ],
                                'from' => [
                                    'type' => 'integer'
                                ],
                                'last_page' => [
                                    'type' => 'integer'
                                ],
                                'path' => [
                                    'type' => 'string', 
                                ],
                                'per_page' => [
                                    'type' => 'integer'
                                ],
                                'to' => [
                                    'type' => 'integer'
                                ],
                                'total' => [
                                    'type' => 'integer'
                                ]
                            ], 
                            'data' => [
                                'type' => 'array[themeObejct]'
                            ], 
                        ],
                        'themeObejct' => [
                            'themeId' => [
                                'type' => 'integer'
                            ],
                            'label' => [
                                'type' => 'string'
                            ], 
                        ],
                    ],
                ], 
            ], 
            'player' => [ 
                'create' => [ 
                    'method' => 'post',
                    'path'   => 'dorehami/player',
                    'params' => [
                        "gameId" => [
                            'type' => 'integer',
                            'required' => true,
                        ],
                        "name" => [
                            'type' => 'string',
                            'required' => true,
                        ],
                        "age" => [
                            'type' => 'string',
                            'values' => Common::ages()->keys(),
                            'required' => true,
                        ],
                        "gender" => [
                            'type' => 'string',
                            'values' => Common::genders()->keys(),
                            'required' => true,
                        ],
                        "marital" => [
                            'type' => 'string',
                            'values' => Common::maritals()->keys(),
                            'required' => true,
                        ],
                    ],
                    'response' => [ 
                        'code'  => 201,
                        'params' => [
                            'status' => [
                                'type' => 'string', 
                            ], 
                            'playerId' => 'integer',
                        ]
                    ]
                ], 
                'update' => [ 
                    'method' => 'post',
                    'path'   => 'dorehami/player/{playerId}',
                    'params' => [
                        "_method" => [
                            "type" => "string",
                            "value"=> "PUT",
                        ], 
                        "name" => [
                            'type' => 'string',
                            'required' => false,
                        ],
                        "age" => [
                            'type' => 'string',
                            'values' => Common::ages()->keys(),
                            'required' => false,
                        ],
                        "gender" => [
                            'type' => 'string',
                            'values' => Common::genders()->keys(),
                            'required' => false,
                        ],
                        "marital" => [
                            'type' => 'string',
                            'values' => Common::maritals()->keys(),
                            'required' => false,
                        ],
                    ],
                    'response' => [ 
                        'code'  => 201,
                        'params' => [
                            'status' => [
                                'type' => 'string', 
                            ], 
                            'playerId' => 'integer',
                        ]
                    ]
                ], 
                // 'show' => [ 
                //     'method' => 'get',
                //     'path'   => 'dorehami/player/{playerId}',
                //     'params' => [  
                //     ],
                //     'response' => [ 
                //         'code'  => 201,
                //         'params' => [
                //             "playerId" => [
                //                 "type" => "integer",
                //             ],
                //             "name" => [
                //                 "type" => "string",
                //             ],
                //             "marital" => [
                //                 "type" => "string", 
                //             ],
                //             "gender" => [
                //                 "type" => "string", 
                //             ],
                //             "age" => [
                //                 "type" => "string", 
                //             ],
                //         ]
                //     ]
                // ], 
            ], 
            'game' => [
                'index' => [
                    'method' => 'get',
                    'path'   => 'dorehami/game',
                    'params' => [
                        'per_page' => [
                            'type' => 'integer',
                            'default' => 15,
                            'required' => false,
                        ],
                        'page' => [
                            'type' => 'integer',
                            'default' => 1,
                            'required' => false,
                        ],
                    ],
                    'response' => [ 
                        'code'  => 200,
                        'params' => [ 
                            'links' => [
                                'first' => [
                                    'type' => 'string',
                                    'nullable' => true,
                                ],
                                'last' => [
                                    'type' => 'string',
                                    'nullable' => true,
                                ],
                                'prev' => [
                                    'type' => 'string',
                                    'nullable' => true,
                                ],
                                'next' => [
                                    'type' => 'string',
                                    'nullable' => true,
                                ],
                            ],

                            'meta' => [
                                'current_page' => [
                                    'type' => 'integer'
                                ],
                                'from' => [
                                    'type' => 'integer'
                                ],
                                'last_page' => [
                                    'type' => 'integer'
                                ],
                                'path' => [
                                    'type' => 'string', 
                                ],
                                'per_page' => [
                                    'type' => 'integer'
                                ],
                                'to' => [
                                    'type' => 'integer'
                                ],
                                'total' => [
                                    'type' => 'integer'
                                ]
                            ], 
                            'data' => [
                                'type' => 'array[gameObejct]'
                            ], 
                        ],
                        'gameObejct' => [
                            'gameId' => [
                                'type' => 'integer'
                            ],
                            'game' => [
                                'type' => 'integer'
                            ],
                            'level' => [
                                'type' => 'string'
                            ],
                            'created_at' => [
                                'type' => 'string',
                                'nullable' => true,
                            ],
                            'updated_at' => [
                                'type' => 'string',
                                'nullable' => true,
                            ],
                            'deleted_at' => [
                                'type' => 'string',
                                'nullable' => true,
                            ],
                        ],
                    ],
                ],
                'create' => [
                    'method' => 'post',
                    'path'   => 'dorehami/game',
                    'params' => [
                        'level' => [
                            'type' => 'string',
                            'values' => Common::levels()->keys(),
                        ], 
                    ],
                    'response' => [
                        'code'  => 201,
                        'params' => [
                            'status' => [
                                'type' => 'string', 
                            ],
                            'gameId' => 'integer',
                        ]
                    ],
                ],
                'update' => [
                    'method' => 'post',
                    'path'   => 'dorehami/game/{gameId}',
                    'params' => [
                        '_method' => [
                            'type' => 'string',
                            'value' => 'PUT',
                            'required' => true,
                        ], 
                        'level' => [
                            'type' => 'string',
                            'required' => true,
                        ], 
                    ],
                    'response' => [
                        'code'  => 200,
                        'params' => [
                            'status' => [
                                'type' => 'string', 
                            ],
                            'gameId' => 'integer',
                        ]
                    ],
                ],  
                'attach' => [  
                    'theme' => [
                        'method' => 'post',
                        'path'   => 'dorehami/game/{gameId}/theme/{themeId}', 
                        'params' => [  
                        ],
                        'response' => [ 
                            'code'  => 201,
                            'params' => [
                                'status' => [
                                    'type' => 'string', 
                                ],  
                            ]
                        ],
                    ], 
                ], 
                'dettach' => [  
                    'theme' => [
                        'method' => 'post',
                        'path'   => 'dorehami/game/{gameId}/theme/{themeId}', 
                        'params' => [  
                            '_method' => [
                                'type'  => 'string',
                                'value' => 'DELETE', 
                            ],
                        ],
                        'response' => [ 
                            'code'  => 200,
                            'params' => [
                                'status' => [
                                    'type' => 'string', 
                                ],  
                            ]
                        ],
                    ], 
                ], 
                'question' => [ 
                    'method' => 'get',
                    'path'   => 'dorehami/game/{gameId}/player/{playerId}/question',
                    'params' => [ 
                        "truth" => [
                            "type" => "boolean",
                            "default" => true,
                            'required' => true,
                        ],
                    ],
                    'response' => [ 
                        'code'  => 200,
                        'params' => [  
                            'questionId' => [
                                'type' => 'integer'
                            ],
                            'question' => [
                                'type' => 'string'
                            ],
                        ], 
                    ],
                ],
                'consequence' => [ 
                    'method' => 'get',
                    'path'   => 'dorehami/game/{gameId}/player/{playerId}/consequence',
                    'params' => [ 
                        "punishment" => [
                            "type" => "boolean",
                            "default" => true,
                            'required' => true,
                        ],
                    ],
                    'response' => [ 
                        'code'  => 200,
                        'params' => [  
                            'consequenceId' => [
                                'type' => 'integer'
                            ],
                            'consequence' => [
                                'type' => 'string'
                            ],
                        ], 
                    ],
                ],
            ],  
            'stage' => [ 
                'create' => [ 
                    'method' => 'post',
                    'path'   => 'dorehami/stage',
                    'params' => [
                        "gameId" => [
                            'type' => 'integer',
                            'required' => true,
                        ],
                        "playerId" => [
                            'type' => 'integer',
                            'required' => true,
                        ],
                        "questionId" => [
                            'type' => 'integer',
                            'required' => true,
                        ], 
                        "stage" => [
                            'type' => 'integer',
                            'required' => true,
                        ],  
                    ],
                    'response' => [ 
                        'code'  => 201,
                        'params' => [
                            'status' => [
                                'type' => 'string', 
                            ], 
                            'stageId' => 'integer',
                        ]
                    ]
                ], 
                'update' => [ 
                    'method' => 'post',
                    'path'   => 'dorehami/stage/{stageId}',
                    'params' => [
                        "_method" => [
                            "type" => "string",
                            "value"=> "PUT",
                        ], 
                        "passed" => [
                            'type' => 'boolean',
                            'required' => true,
                            'default' => false,
                        ], 
                        "consequenceId" => [
                            'type' => 'integer',
                            'nullable' => true,
                        ],   
                    ],
                    'response' => [ 
                        'code'  => 200,
                        'params' => [
                            'status' => [
                                'type' => 'string', 
                            ], 
                            'stageId' => 'integer',
                        ]
                    ]
                ],  
            ], 
        ]);
    } 
}
