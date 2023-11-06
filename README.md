# Kirby Snippet Controller
Define snippet controllers in a similar way to how page controllers work.

## How to use it
By default the plugin will try to find controllers in your `snippets` directory.
Lets have a look at a example `header` snippet.

```bash
📁 snippets
├─ 📄 header.controller.php
└─ 📄 header.php
```

```php
// header.controller.php

// The return value can be a callback
return function ($site) {
    return [
        'title' => $site->title(),
    ];
};

// Or you can simply return an array.
return [
    'title' => site()->title(),
];

```

You can also define snippet controllers in a plugin.
```php
Kirby::plugin('superwoman/superplugin', [
    'snippets' => [

        // Refer to a file
        'header.controller' => __DIR__ . '/snippets/header.controller.php',

        // Return an array
        'header.controller' => [
            'title' => site()->title(),
        ],

        // Return a callback
        'header.controller' => function ($site) {
            return [
                'title' => $site->title(),
            ];
        },

    ],
]);
```

### Available callback arguments in your controllers
You have access to all variables that are also accessible in the snippet.
If you pass additional data to the snippet, you can access it in the controller as well.

> **Note**
> Since version [`2.0.0`](https://github.com/lukaskleinschmidt/kirby-snippet-controller/releases/tag/2.0.0) and Kirby [`3.9.6`](https://github.com/getkirby/kirby/releases/tag/3.9.6) you can also use variadic arguments.

```php
snippet('header', data: ['title' => 'My Title'])

// header.controller.php

return function (string $title = 'Default Title', ...$args) {
    return [
        'title' => $title,
    ];
};
```

> **Note**
> Since version [`2.1.0`](https://github.com/lukaskleinschmidt/kirby-snippet-controller/releases/tag/2.1.0) you can override variables when using a controller callback.

```php
snippet('header', data: ['size' => $page->size()])

// header.controller.php

return function (Field|string $size = null) {

    if ($size instanceof Field) {
        $size = $size->value();
    }

    $size = match ($size) {
        'small'  => 'height: 50vh',
        'medium' => 'height: 80vh',
        default  => 'height: 100vh',
    };

    return [
        'size' => $size,
    ];
};
```

> **Note**
> Since version [`2.2.0`](https://github.com/lukaskleinschmidt/kirby-snippet-controller/releases/tag/2.2.0) you can prevent a snippet from rendering in a controller callback.

```php
snippet('header', data: ['size' => $page->size()])

// header.controller.php

return function (Field|string $size = null) {
    if (is_null($size)) {
        snippet_prevent();
    }

    return [
        'size' => $size,
    ];
};
```

### Naming convention
By default, the plugin searches for controllers by appending `.controller` to the snippet name.
You can change the name resolver in the options. Changing the name also affects plugin-defined controllers.
```php
// config.php

return [
    'lukaskleinschmidt.snippet-controller' => [

        // The default resolver
        'name' => fn (string $name) => $name . '.controller',

        // You might want to store controllers in a separate folder
        'name' => fn (string $name) => 'controllers/' . $name,

    ],
];

```

## Commercial Usage
This plugin is free. Please consider to [make a donation](https://www.paypal.me/lukaskleinschmidt/5EUR) if you use it in a commercial project.

## Installation

### Download
Download and copy this repository to `/site/plugins/snippet-controller`.

### Git submodule
```
git submodule add https://github.com/lukaskleinschmidt/kirby-snippet-controller.git site/plugins/snippet-controller
```

### Composer
```
composer require lukaskleinschmidt/kirby-snippet-controller
```

## License
MIT

## Credits
- [Lukas Kleinschmidt](https://github.com/lukaskleinschmidt)
