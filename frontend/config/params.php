<?php
return [
    'adminEmail' => 'admin@example.com',
    'ustatus'=>[
        1=>'Yangi',
        2=>'Jarayonda',
        3=>'Tasdiqlanishi kutilmoqda',
        4=>'Tugallangan'
    ],
    'shift'=>[
        1=>'Tezkor tergov guruhi',
        2=>'Tungi guruh',
    ],
    'active'=>[
        2=>'Ish vaqti emas',
        1=>'Onlayn',
        0=>'Oflayn'
    ],
    'estatus'=>[
        1=>'Yangi',
        2=>'Jarayonda',
        3=>'Tugallangan',
        4=>'Tugallangan'
    ],
    'user.status'=>[
        1=>'Aktiv',
        0=>'Deaktiv',
        -1=>'O`chirilgan'
    ],
    'company.status'=>[
        1=>'Aktiv',
        0=>'Deaktiv',
        -1=>'O`chirilgan'
    ],
    'company.work_status'=>[
        1=>'Ochiq',
        0=>'Yopiq',
    ],
    'food.status'=>[
        1=>'Aktiv',
        0=>'Deaktiv',
        -1=>'O`chirilgan'
    ],
    'request.status'=>[
        1=>'Yuborilgan',
        2=>'Javob berilgan'
    ],
    'gender'=>[
        0=>'Ayol',
        1=>'Erkak'
    ],
     'active_type'=>[
        '0'=>'Oflayn',
        '1'=>'Onlayn',
        2=>'Ish vaqti emas',
    ],
    'sms'=>[
        'email'=>'online.software.it.v2@mail.ru',
        'password'=>'5AQc6WqxisH7KSc7xKvR0yz8yYo7reFOkVhaKeJ7',
        'url'=>[
            'auth'=>[
                'url'=>'notify.eskiz.uz/api/auth/login',
                'method'=>'POST',
            ],
            'refresh'=>[
                'url'=>'notify.eskiz.uz/api/auth/refresh',
                'method'=>'PATCH'
            ],
            'delete'=>[
                'url'=>'notify.eskiz.uz/api/auth/invalidate',
                'method'=>'DELETE'
            ],
            'user'=>[
                'url'=>'notify.eskiz.uz/api/auth/user',
                'method'=>'GET'
            ],
            'send'=>[
                'url'=>'notify.eskiz.uz/api/message/sms/send',
                'method'=>'POST',
            ]
        ]
    ]
];
