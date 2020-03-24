<?php
/**
 * HashMap
 * User: sammy le
 * Date: 2020-03-23
 * Time: 21:57
 */
require 'List.php';
require 'HashCode.php';

class HashMap
{
    private $array = [];
    private $capacity;
    private $size;

    const LOAD_FACTOR = 0.75;
    const RESIZE_TIMES = 2;

    public function __construct($capacity)
    {
        $this->capacity = $capacity;
    }

    public function hash($string)
    {
        return hashCode64($string) % $this->capacity;
    }

    /**
     * remove element
     *
     * @param $key
     * @return bool
     */
    public function pop($key)
    {
        if (empty($key)) {
            return false;
        }
        $index = $this->hash($key);
        // the key not exist the array
        if (!isset($this->array[$index])) {
            return false;
        }
        $node = $this->array[$index];
        if ($node->key === $key) {
            unset($this->array[$index]);
        } else {
            //search the list
            $temp = $node;
            while ($temp->next !== null) {
                $temp = $temp->next;
                if ($temp->key === $key) {
                    if ($temp->next === null) {
                        $temp->prev->next = null;
                    } else {
                        $temp->prev->next = $temp->next;
                        $temp->next->prev = $temp->prev;
                    }
                    unset($node);
                }
            }
        }

        return true;
    }

    public function get($key)
    {
        if (empty($key)) {
            return false;
        }
        $index = $this->hash($key);
        if (!isset($this->array[$index])) {
            return false;
        }
        $node = $this->array[$index];
        if ($node->key === $key) {
            return $node->val;
        }
        if ($node->next === null) {
            return false;
        }
        $temp = $node;
        while ($temp->next !== null) {
            $temp = $temp->next;
            if ($temp->key === $key) {
                return $temp->val;
            }
        }

        return false;
    }

    public function put($key, $val)
    {
        if (empty($key)) {
            return false;
        }
        $this->reSize();
        $newNode = new Node($key, $val);
        $this->conflict($this->array, $newNode);
        $this->size += 1;

        return $this->array;
    }

    private function conflict(&$array, $node)
    {
        $index = $this->hash($node->key);
        if (!isset($array[$index])) {
            $array[$index] = $node;
        } else {
            // the index not exist
            $head = $array[$index];
            // same index and key
            if ($node->key === $head->key) {
                // update
                $array[$index] = $node;
            } else {
                // move behind of the head
                $head->next->prev = $node;
                $node->next = $head->next;
                $head->next = $node;
                $node->prev = $head;
            }
        }
    }

    public function reSize()
    {
        $count = 0;
        if ($this->size >= $this->capacity * self::LOAD_FACTOR) {
            $count++;
            echo 'resize...' . $count . '<br />';
            $tempArray = [];
            $this->capacity *= self::RESIZE_TIMES;
            foreach ($this->array as $index => $node) {
                if ($node->next === null) {
                    $this->conflict($tempArray, $node);
                } else {
                    $temp = $node;
                    while ($temp->next !== null) {
                        $this->conflict($tempArray, $temp);
                        $temp = $temp->next;
                    }
                }
            }
            $this->array = $tempArray;
        }
    }

    public function output()
    {
        var_dump($this->array);
    }
}

//test
//the hash collision not test
//$hp = new HashMap(5);

//$hp->put('a', 1);
//$hp->put('b', 2);
//$hp->put('c', 3);
//$hp->put('d', 4);

// resize...
//$hp->put('e', 5);
//$hp->put('f', 6);

// update val
//$hp->put('f', 7);

//echo $hp->get('a');
// del val
//$hp->pop('a');
//$hp->output();
