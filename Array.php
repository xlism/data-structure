<?php
/**
 * array
 * User: sammyle
 * Date: 2020-03-23
 * Time: 09:42
 */

class Arr
{
    private $array = [];
    private $length = 0;

    public function __construct(Array $array)
    {
        $this->array = $array;
        $this->length = count($this->array);
    }

    public function get($key)
    {
        return isset($this->array[$key]) ? $this->array[$key] : null;
    }

    public function set($key, $val)
    {
        isset($this->array[$key]) ? ($this->array[$key] = $val) : false;

        return $this->array;
    }

    public function remove($key)
    {
        if (!isset($this->array[$key])) {
            return false;
        }
        unset($this->array[$key]);
        $this->length -= 1;

        return $this->array;
    }

    /**
     * insert
     * Move the array back and forth from the last element
     *
     * @param $key
     * @param $val
     * @return array
     */
    public function insert($key, $val)
    {
        $this->offset($key);
        $this->array[$key] = $val;
        //do not forget +1
        $this->length += 1;

        return $this->array;
    }

    private function offset($index)
    {
        for ($i = $this->length - 1; $i >= $index; $i--) {
            $this->array[$i + 1] = $this->array[$i];
        }
    }
}

//test
$array = new Arr([1, 2, 3, 4, 5]);
// random get
echo $array->get(0);
// update
var_dump($array->set(0, 2));
// insert to head
var_dump($array->insert(0, 3));
// insert to middle
var_dump($array->insert(2, 4));
// inset to last
var_dump($array->insert(7, 5));
