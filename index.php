<?php

use Kirby\Cms\App;
use Kirby\Template\Snippet;
use LukasKleinschmidt\PreventSnippetException;

@include_once __DIR__ . '/helpers.php';
@include_once __DIR__ . '/PreventSnippetException.php';

App::plugin('lukaskleinschmidt/snippet-controller', [
    'options' => [
        'name' => fn (string $name) => $name . '.controller',
    ],
    'components' => [
        'snippet' => function (App $kirby, $name, array $data = [], bool $slots = false): Snippet|string
        {
            try {
                $data = snippet_controller($name, $data);
            } catch (PreventSnippetException) {
                return '';
            }

            return $kirby->nativeComponent('snippet')(
                $kirby,
                $name,
                $data,
                $slots,
            );
        }
    ],
]);
