<?php
/**
 * stack
 * User: sammyle
 * Date: 2020-03-23
 * Time: 16:58
 */
require 'List.php';

class ListStack
{
    private $list;

    public function __construct()
    {
        $this->list = new LinkedList();
    }

    public function push($data)
    {
        $node = new Node($data);
        $this->list->insert($node, $this->list->getLength());

        return $this->list;
    }

    public function pop()
    {
        $this->list->remove($this->list->getLength() - 1);

        return $this->list;
    }

    public function output()
    {
        $this->list->output();
    }
}

class ArrayStack
{
    private $array = [];
    private $length = 0;

    public function __construct()
    {
    }

    public function pop()
    {
        if ($this->length == 0) {
            return false;
        }
        $last = array_pop($this->array);
        $this->length -= 1;

        return $last;
    }

    public function push($data)
    {
        $this->array[] = $data;
        $this->length += 1;

        return $this;
    }

    public function output()
    {
        var_dump($this->array);
    }
}