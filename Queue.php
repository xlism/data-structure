<?php
/**
 * Queue
 * User: sammyle
 * Date: 2020-03-23
 * Time: 21:19
 */
require 'Array.php';
require 'List.php';

interface Queue
{
    public function in($element);

    public function out();
}

class arrayQueue implements Queue
{
    private $array;

    public function __construct()
    {
        $this->array = new Arr([]);
    }

    public function in($element)
    {
        $this->array->insert($this->array->getLength(), $element);

        return $this->array;
    }

    public function out()
    {
        $this->array->remove(0);

        return $this->array;
    }

    public function output()
    {
        $this->array->output();
    }
}

class ListQueue implements Queue
{
    private $list;

    public function __construct()
    {
        $this->list = new LinkedList();
    }

    public function in($element)
    {
        $node = new Node($element);
        $this->list->insert($node, $this->list->getLength());

        return $this;
    }

    public function out()
    {
        $this->list->remove(0);

        return $this;
    }

    public function output()
    {
        $this->list->output();
    }
}
