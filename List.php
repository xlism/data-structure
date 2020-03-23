<?php

/**
 * the list
 * User: sammyle
 * Date: 2020-03-23
 * Time: 10:53
 */
class Node {
    private $data;
    private $next;

    public function __construct($data) {
        $this->data = $data;
    }

    public function __get($name) {
        return $this->$name;
    }

    public function __set($name, $value) {
        $this->$name = $value;
    }
}

class myList {
    private $head;
    private $tail;
    private $length;

    public function __construct() {
        $this->head = new Node(NULL);
    }

    /**
     * get node by index
     *
     * @param $index
     * @return bool|Node
     */
    public function get($index) {
        if ($index < 0 || $index >= $this->length) {
            return FALSE;
        }
        $temp = $this->head;
        for ($i = 0; $i < $index; $i++) {
            $temp = $temp->next;
        }

        return $temp;
    }

    public function insert(Node $node, $index) {
        if ($index < 0 || $index > $this->length) {
            return FALSE;
        }
        if ($this->length == 0) {
            $this->head = $node;
            $this->tail = $node;
        } else if ($index == 0) {
            $node->next = $this->head;
            $this->head = $node;
        } else if ($index > 0 && $index < $this->length) {
            $prevNode = $this->get($index - 1);
            $node->next = $prevNode->next;
            $prevNode->next = $node;
        } else if ($index == $this->length) {
            $this->tail->next = $node;
            $this->tail = $node;
        }
        $this->length += 1;

        return $this;
    }

    public function remove($index) {
        if ($index < 0 || $this->length == 0 || $index >= $this->length) {
            return FALSE;
        }
        if ($index == 0) {
            $this->head = $this->head->next;
        } else if ($index == $this->length - 1) {
            $prevNode = $this->get($index - 1);
            $prevNode->next = NULL;
            $this->tail = $prevNode;
        } else {
            $prevNode = $this->get($index - 1);
            $node = $this->get($index);
            $prevNode->next = $node->next;
        }
        $this->length -= 1;

        return $this;
    }

    public function output() {
        $temp = $this->head;
        while ($temp != NULL) {
            echo $temp->data;
            $temp = $temp->next;
        }
        echo '<br/>';
    }

    public function getLength() {
        return $this->length;
    }
}

//test
$list = new myList();

$list->insert(new Node(1), 0);
$list->insert(new Node(2), $list->getLength());
$list->insert(new Node(3), $list->getLength());
$list->insert(new Node(4), $list->getLength());
$list->output();

//insert to middle
$list->insert(new Node(5), rand(1, $list->getLength() - 1));
$list->output();

//insert to head
$list->insert(new Node(6), 0);
$list->output();

//insert to tail
$list->insert(new Node(7), $list->getLength());
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
