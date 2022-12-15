<?php

use Kirby\Cms\App;

@include_once __DIR__ . '/helpers.php';

App::plugin('lukaskleinschmidt/snippet-controller', [
    'options' => [
        'name' => fn (string $name) => $name . '.controller',
    ],
    'components' => [
        'snippet' => function (App $kirby, $name, array $data = [], bool $slots = false) {
            $data = snippet_controller($name, $data);

            return $kirby->core()->components()['snippet'](
                $kirby,
                $name,
                $data,
                $slots,
            );
        }
    ],
]);
