<?php

namespace Vanmoof\Infrastructure;

use Symfony\Component\DependencyInjection\EnvVarProcessorInterface;

class FixEscapingMysqlPasswordEnvVar implements EnvVarProcessorInterface
{
    public function getEnv(string $prefix, string $name, \Closure $getEnv): mixed
    {
        $env = $getEnv($name);

        return urlencode($env);
    }

    public static function getProvidedTypes(): array
    {
        return [
            'urlencode' => 'string',
        ];
    }
}
