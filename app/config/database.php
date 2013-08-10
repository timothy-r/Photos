<?php

return array(

   /* Configuration section name*/
    'default' => 'development',
    'development' => array(
        'connection' => array(
            'hostnames' => 'localhost',
            'database'  => 'development',
//          'username'  => '',
//          'password'  => '',
        )
    ),
    'production' => array(
            'connection' => array(
                'hostnames' => 'localhost',
                'database'  => 'production',
//              'username'  => '',
//              'password'  => '',
            )
    )

);
