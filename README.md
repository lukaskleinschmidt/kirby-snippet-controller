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
    'value' => site()->title(),
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
Like in regular controllers, you can access the `$site`, `$page`, `$pages` and `$kirby` objects by loading them as arguments to the anonymous function. The plugin will inject the right objects for you. In addition, you also have access to the `$data` argument, which is the array of data you passed to the snippet.

```php
<?php snippet('header', data: ['title' => 'My Title']) ?>
```

### Naming convention
By default, the plugin searches for controllers by appending `.controller` to the snippet name. You can change the name resolver in the options. Changing the name also affects plugin-defined controllers.
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
