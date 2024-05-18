<?php

declare(strict_types=1);

namespace Mikhail\PrimitiveWrappers\Str\Traits;

use function lcfirst;
use function mb_strtoupper;
use function preg_replace_callback;

trait CaseConversionTrait
{
    /**
     * convert string to snake case
     */
    public function snake(): static
    {
        $callback = static function (array $matches): string {
            return !empty($matches[1]) ? $matches[1] . '_' . $matches[2] : '_';
        };

        $snake = preg_replace_callback(
            '/([a-z0-9])([A-Z])|[\s-]+/',
            $callback,
            $this->str
        );

        return (new static($snake))->toLower();
    }

    /**
     * convert string to camel case
     */
    public function camel(): static
    {
        $callback = static function (array $matches): string {
            return mb_strtoupper($matches[1]);
        };

        $camel = preg_replace_callback(
            '/(?:[_ -]|^)([a-z0-9])/i',
            $callback,
            $this->str
        );

        $camel = lcfirst($camel);

        return new static($camel);
    }

    /**
     * convert string to kebab case
     */
    public function kebab(): static
    {
        $callback = static function (array $matches): string {
            return !empty($matches[1]) ? $matches[1] . '-' . $matches[2] : '-';
        };

        $kebab = preg_replace_callback(
            '/([a-z0-9])([A-Z])|[\s_]+/',
            $callback,
            $this->str
        );

        return (new static($kebab))->toLower();
    }
}
