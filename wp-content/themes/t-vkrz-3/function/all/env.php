<?php

    function env(){
        $local_env = [
            'localhost',
            '127.0.0.1'
        ];

        if (in_array( $_SERVER['SERVER_NAME'], $local_env)) {
            return "local";
        }

        return "prod";
    }