<?php

use Kirby\Cms\App;
use Kirby\Filesystem\F;
use Kirby\Toolkit\A;
use Kirby\Toolkit\Controller;
use LukasKleinschmidt\PreventSnippetException;

if (! function_exists('snippet_controller_value')) {
    /**
     * Returns the snippet controller value.
     */
    function snippet_controller_value(string|array $name): mixed
    {
        $kirby = App::instance();
		$names = A::wrap($name);
        $root = $kirby->root('snippets');

		foreach ($names as $name) {
			$name = $kirby->option('lukaskleinschmidt.snippet-controller.name')($name, $kirby);
			$file = $root . '/' . $name . '.php';

			if (file_exists($file) === false) {
				$file = $kirby->extensions('snippets')[$name] ?? null;
			}

			if ($file) {
				break;
			}
		}

        return $file;
    }
}

if (! function_exists('snippet_controller')) {
    /**
     * Aggregates snippet data.
     */
    function snippet_controller(string|array $name, array $data = []): array
    {
        if (is_null($value = snippet_controller_value($name))) {
            return $data;
        }

        if (is_string($value) && is_file($value)) {
            $value = F::load($value);
        }

        if (is_array($value)) {
            return array_merge($value, $data);
        }

        if ($value instanceof Closure) {
            $value = (new Controller($value))->call(App::instance(), $data);
        }

        return is_array($value) ? array_merge($data, $value) : $data;
    }
}

if (! function_exists('snippet_prevent')) {
    /**
     * Prevent a snippet from rendering.
     * Should only be used in snippet controller callbacks.
     *
     * @throws \LukasKleinschmidt\PreventSnippetException
     */
    function snippet_prevent(): never
    {
        throw new PreventSnippetException;
    }
}
