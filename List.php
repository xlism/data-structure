<?php

/**
 * the list
 * User: sammyle
 * Date: 2020-03-23
 * Time: 10:53
 */
class Node
{
    private $key;
    private $val;
    private $next;
    private $prev;

    public function __construct($key, $data)
    {
        $this->key = $key;
        $this->val = $data;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}

class DoublyLinkedList
{
    public $head;
    public $tail;
    private $length;

    public function __construct()
    {
        $this->head = new Node(null, null);
    }

    public function getLength()
    {
        return $this->length;
    }

    public function insert(Node $node, $index)
    {
        if ($index < 0 || $index > $this->length) {
            return false;
        }
        if ($this->length == 0) {
            $this->head = $node;
            $this->tail = $node;
            $this->head->next = $this->tail;
            $this->tail->prev = $this->head;
        } else {
            if ($index == 0) {
                $node->next = $this->head;
                $this->head->prev = $node;
                $this->head = $node;
            } else {
                if ($index > 0 && $index < $this->length) {
                    $prevNode = $this->get($index - 1);
                    $nextNode = $this->get($index + 1);
                    $node->next = $nextNode;
                    $node->prev = $prevNode;
                    $prevNode->next = $node;
                    $nextNode->prev = $node;
                } else {
                    if ($index == $this->length) {
                        $this->tail->next = $node;
                        $node->prev = $this->tail;
                        $this->tail = $node;
                    }
                }
            }
        }
        $this->length += 1;

        return $this;
    }

    public function remove($index)
    {
        if ($index < 0 || $this->length == 0 || $index >= $this->length) {
            return false;
        }
        if ($index == 0) {
            $this->head = $this->head->next;
            $this->head->prev = null;
        } else {
            if ($index == $this->length - 1) {
                $prevNode = $this->get($index - 1);
                $prevNode->next = null;
                $this->tail = $prevNode;
            } else {
                $prevNode = $this->get($index - 1);
                $nextNode = $this->get($index + 1);
                $prevNode->next = $nextNode;
                $nextNode->prev = $prevNode;
            }
        }
        $this->length -= 1;

        return $this;
    }

    public function get($index)
    {
        if ($index < 0 || $index >= $this->length) {
            return false;
        }
        $temp = $this->head;
        for ($i = 0; $i < $index; $i++) {
            $temp = $temp->next;
        }

        return $temp;
    }
}

class LinkedList
{
    private $head;
    private $tail;
    private $length;

    public function __construct()
    {
        $this->head = new Node(null, null);
    }

    /**
     * get node by index
     *
     * @param $index
     * @return bool|Node
     */
    public function get($index)
    {
        if ($index < 0 || $index >= $this->length) {
            return false;
        }
        $temp = $this->head;
        for ($i = 0; $i < $index; $i++) {
            $temp = $temp->next;
        }

        return $temp;
    }

    public function insert(Node $node, $index)
    {
        if ($index < 0 || $index > $this->length) {
            return false;
        }
        if ($this->length == 0) {
            $this->head = $node;
            $this->tail = $node;
        } else {
            if ($index == 0) {
                $node->next = $this->head;
                $this->head = $node;
            } else {
                if ($index > 0 && $index < $this->length) {
                    $prevNode = $this->get($index - 1);
                    $node->next = $prevNode->next;
                    $prevNode->next = $node;
                } else {
                    if ($index == $this->length) {
                        $this->tail->next = $node;
                        $this->tail = $node;
                    }
                }
            }
        }
        $this->length += 1;

        return $this;
    }

    public function remove($index)
    {
        if ($index < 0 || $this->length == 0 || $index >= $this->length) {
            return false;
        }
        if ($index == 0) {
            $this->head = $this->head->next;
        } else {
            if ($index == $this->length - 1) {
                $prevNode = $this->get($index - 1);
                $prevNode->next = null;
                $this->tail = $prevNode;
            } else {
                $prevNode = $this->get($index - 1);
                $node = $this->get($index);
                $prevNode->next = $node->next;
            }
        }
        $this->length -= 1;

        return $this;
    }

    public function output()
    {
        $temp = $this->head;
        while ($temp != null) {
            echo $temp->val;
            $temp = $temp->next;
        }
        echo '<br/>';
    }

    public function getLength()
    {
        return $this->length;
    }
}

//test
$list = new LinkedList();

$list->insert(new Node(1,1), 0);
$list->insert(new Node(2,2), $list->getLength());
$list->insert(new Node(3,3), $list->getLength());
$list->insert(new Node(4,4), $list->getLength());
$list->output();

//insert to middle
$list->insert(new Node(5,5), rand(1, $list->getLength() - 1));
$list->output();

//insert to head
$list->insert(new Node(6,6), 0);
$list->output();

//insert to tail
$list->insert(new Node(7,7), $list->getLength());
$list->output();

//remove the head node
$list->remove(0);
$list->output();

//remove the middle node
$list->remove(rand(1, $list->getLength() - 1));
$list->output();

//remove the tail node
$list->remove($list->getLength() - 1);
$list->output();

//get head node
var_dump($list->get(0));
//get tail node
var_dump($list->get($list->getLength() - 1));
//get middle node
var_dump($list->get(rand(1, $list->getLength() - 1)));

//exception test
var_dump($list->get(-1));
var_dump($list->get($list->getLength()));
var_dump($list->get($list->getLength() + 1));
//...
