<?php

namespace App\Traits;

class EnumHelper
{
    public function fromValue(string $value)
    {
        $class = get_called_class();
        $constants = (new \ReflectionClass($class))->getConstants();
        $key = array_search($value, $constants, true);
        if ($key === false) {
            throw new \InvalidArgumentException("Value '$value' is not part of the enum $class");
        }
        return new $class($key);
    }
}