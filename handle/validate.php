<?php
$validates=[
    'name'=>[
        'filters'=>FILTER_VALIDATE_REGEXP,
        'error'=>'name is required',
        'myoption'=>[
            'options'=>['regexp'=>'/[a-zA-Z]$/']
        ]
    ],
    'email'=>[
        'filters'=>FILTER_VALIDATE_EMAIL,
        'error'=>'email is required'
    ],
    'password'=>[
        'filters'=>FILTER_VALIDATE_REGEXP,
        'error'=>'password is required',
        'myoption'=>[
            'options'=>['regexp'=>'/[a-zA-Z]$/']
        ]
    ],
    'phone'=>[
        'filters'=>FILTER_VALIDATE_INT,
        'error'=>'phone is required'
    ]
];