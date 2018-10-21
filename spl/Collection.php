<?php

class Collection implements JsonSerializable, ArrayAccess, Iterator, Countable
{
    protected $collection;

    public function __construct()
    {
        $this->collection = [];
    }

    /**
     * @param $offset
     * @return mixed|null
     */
    public function __invoke($offset = 0)
    {
        return $this->offsetExists($offset) ? $this->collection[$offset] : null;
    }

    public function jsonSerialize()
    {
        return $this->collection;
    }

    public function offsetExists($offset)
    {
        return isset($this->collection[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->collection[$offset] : null;
    }

    public function offsetSet($offset, $value):void
    {
        if (is_null($offset)) {
            $this->collection[] = $value;
        } else {
            $this->collection[$offset] = $value;
        }
    }

    public function offsetUnset($offset):void
    {
        unset($this->collection[$offset]);
    }

    public function current()
    {
        return current($this->collection);
    }

    public function next():void
    {
        next($this->collection);
    }

    public function key()
    {
        return key($this->collection);
    }

    public function valid():bool
    {
        return null !== key($this->collection);
    }

    public function rewind():void
    {
        reset($this->collection);
    }

    public function count()
    {
        return count($this->collection);
    }
}