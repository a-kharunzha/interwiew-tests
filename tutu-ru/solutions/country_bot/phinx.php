<?php

require_once 'bootstrap.php';

// не использую yml, чтобы не дублировать доступы к БД в файле
return [
    "paths" => [
        "migrations" => __DIR__.'/db/migrations'
    ],
    "environments" => [
        "default_migration_table" => "phinxlog",
        "default_database" => "dev",
        "dev" => [
            "adapter" => "mysql",
            "host" => $_ENV['DB_HOST'],
            "name" => $_ENV['DB_NAME'],
            "user" => $_ENV['DB_USER'],
            "pass" => $_ENV['DB_PASS'],
            "port" => $_ENV['DB_PORT']
        ]
    ]
];
