<?php

$rest = [
    'v1' => [
        'title' => 'LimeSurvey V1',
        'description' => 'LimeSurvey V1 REST API',
        'tags' => [
            'survey' => [
                'name' => 'Survey',
                'description' => 'Survey',
            ],
            'auth' => [
                'name' => 'Auth',
                'description' => 'Auth',
            ],
            'session' => [
                'name' => 'Session',
                'description' => 'Session',
            ]
        ]
    ]
];

return array_merge(
    $rest,
    include_once __DIR__ . '/v1/survey.php',
    include_once __DIR__ . '/v1/auth.php',
    include_once __DIR__ . '/v1/session.php'
);
