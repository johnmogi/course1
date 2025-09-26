<?php

namespace WCL;

use Closure;
use InvalidArgumentException;

class ServiceContainer
{
    /**
     * @var array<class-string, Closure>
     */
    private array $bindings = [];

    /**
     * @var array<class-string, object>
     */
    private array $instances = [];

    /**
     * Register a singleton binding.
     *
     * @param class-string $abstract
     * @param Closure $factory
     */
    public function singleton(string $abstract, Closure $factory): void
    {
        $this->bindings[$abstract] = $factory;
    }

    /**
     * Resolve an instance.
     *
     * @param class-string $abstract
     * @return object
     */
    public function get(string $abstract): object
    {
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        if (!isset($this->bindings[$abstract])) {
            throw new InvalidArgumentException("Service {$abstract} is not bound in the container.");
        }

        $this->instances[$abstract] = ($this->bindings[$abstract])();

        return $this->instances[$abstract];
    }
}
