<?php

    function env(){
        $local_env = [
            'localhost',
            'localhost:8888',
            'bltzr.fr',
            'bltzr.fr/vkrz',
            '127.0.0.1'
        ];

        if (in_array( $_SERVER['SERVER_NAME'], $local_env)) {
            return "local";
        }

        return "prod";
    }