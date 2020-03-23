<?php
/**
 * HashMap
 * User: sammyle
 * Date: 2020-03-23
 * Time: 21:57
 */
require 'Array.php';
require 'List.php';

class HashMap
{
    private $array;
    private $capacity;
    private $size;

    public function __construct($capacity)
    {
        $this->array = new Arr([]);
        $this->capacity = $capacity;
    }

    public function hash($string)
    {
        return hash('md5', $string, false) % $this->capacity;
    }

    public function get($key)
    {
        if(empty($key)){
            return false;
        }
        $index = $this->hash($key);
        if(!isset($this->array[$index])){
            return false;
        }
        $node = $this->array[$index];
        if($node->key === $key) {
            return $node->val;
        }
        if($node->next === null){
            return false;
        }
        $temp = $node;
        while ($temp->next !== null){
            $temp = $temp->next;
            if($temp->key === $key){
                return $temp->val;
            }
        }
        return false;
    }

    public function put($key, $val)
    {
        if(empty($key)){
            return false;
        }
        $this->reSize();
        $newNode = new Node($key, $val);
        $this->conflict($this->array, $newNode);
        $this->size+=1;
        return $this->array;
    }

    private function conflict(&$array, $node)
    {
        $index = $this->hash($node->key);
        if(!isset($array[$index])){
            $array[$index] = $node;
        }else {
            $head = $array[$index];
            $node->next = $head;
            $node->prev = null;
            $head->prev = $node;
            $array[$index] = $node;
        }
    }

    public function reSize()
    {
        if($this->size >= $this->capacity * 0.75){
            $tempArray = [];
            foreach ($this->array as $index=>$node){
                if($node->next === null){
                    $this->conflict($tempArray, $node);
                }else{
                    $temp = $node;
                    while ($temp->next !== null){
                        $this->conflict($tempArray, $temp);
                        $temp = $temp->next;
                    }
                }
            }
            $this->array = $tempArray;
        }
    }
}