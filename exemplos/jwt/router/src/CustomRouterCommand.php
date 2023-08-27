<?php
namespace Router;

use Buki\Router\RouterCommand;
use function \DI\get;

class CustomRouterCommand extends RouterCommand
{

    /**
     * Resolve Controller or Middleware class.
     *
     * @param string $class
     * @param string $path
     * @param string $namespace
     *
     * @return object
     * @throws \Exception
     */
    protected function resolveClass(string $class, string $path, string $namespace): object
    {
        $class = str_replace([$namespace, '\\'], ['', '/'], $class);
        $file = realpath("{$path}/{$class}.php");
        if (!file_exists($file)) {
            $this->exception("{$class} class is not found. Please check the file.");
        }

        $class = $namespace . str_replace('/', '\\', $class);
        if (!class_exists($class)) {
            require_once($file);
        }
        // dd(new $class);
        global $containerProvider;

        return $containerProvider->get($class);
    }
}