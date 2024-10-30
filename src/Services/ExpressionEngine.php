<?php

namespace Mantiq\Services;

use Mantiq\Concerns\Singleton;
use Mantiq\Support\Arrays;
use Mantiq\Support\Strings;
use MantiqVendors\Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class ExpressionEngine
{
    use Singleton;

    protected $engine;

    public function __construct()
    {
        $this->engine = new ExpressionLanguage();
    }

    public static function evaluate($expression, $context = [])
    {
        return static::instance()->apply($expression, $context);
    }

    public static function evaluateWithoutEscaping($expression, $context = [])
    {
        $expression = str_replace('}', '|raw}', $expression);

        return static::instance()->apply($expression, $context);
    }

    public static function rawEvaluate($expression, $context = [])
    {
        return static::instance()->applyRaw($expression, $context);
    }

    public static function rawValue($expression, $context = [])
    {
        return static::instance()->applyRawValue($expression, $context);
    }

    public function applyRaw($expression, $context = [])
    {
        return $this->engine->evaluate($expression, is_array($context) ? $context : $context->toArray());
    }

    public function applyRawValue($expression, $context = [])
    {
        $expression = str_replace(['{', '}'], '', $expression);

        return Arrays::get($context, $expression);
    }

    public function apply($expression, $context = [])
    {
        if (strpos($expression, '{{') !== false) {
            return preg_replace_callback(
                '/{{(?P<expression>(.*?))}}/sim',
                function ($matches) use ($context) {
                    return $this->engine->evaluate($matches['expression'], $context);
                },
                $expression
            );
        }

        return Strings::template($expression, $context);
    }
}
