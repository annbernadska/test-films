<?php

return [
    'search' => '/film/search',
    'import' => '/film/import',
    'view/([0-9]+)' => '/film/view/$1',
    'create' => '/film/create',
    'store' => '/film/store',
    'edit/([0-9]+)' => '/film/edit/$1',
    'update/([0-9]+)' => '/film/update/$1',
    'delete/([0-9]+)' => '/film/delete/$1',

    'index.php' => '/film/index',
    '/' => '/film/index',
    '' => '/film/index',
];