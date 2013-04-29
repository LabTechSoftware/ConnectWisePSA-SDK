<?php namespace ConnectWisePSA;

use Exception,
    stdClass;


abstract class ConnectWisePSARequest {

    public function __set($name, $value)
    {
        // TODO: Maybe we need some type of type restriction?
        // echo "Setting '$name' from ".$this->{$name}."(".gettype($this->{$name}).") to '$value'(".gettype($value).")\n";
        $this->{$name} = $value;
    }

    public function __get($name)
    {
        return $this->{$name};
    }

    public function __isset($name)
    {
        return isset($this->{$name});
    }

    public function __unset($name)
    {
        unset($this->{$name});
    }

}