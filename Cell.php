<?php

class Cell {

    function __construct($x, $y, $is_alive = false) {
    $this->x = $x;
    $this->y = $y;
    $this->is_alive = $is_alive;
    $this->is_alive_in_next_generation = null;
    $this->neighbours = null;
    }

    public function draw() {
    return $this->is_alive ? "$this->x.$this->y" : '|***|';
    }

}

?>