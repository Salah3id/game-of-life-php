<?php

require_once('Cell.php');

class Universe {

  function __construct() {
    $this->width = 25;
    $this->height = 25;
    $this->cells = array();
    $this->eight_directions = [
    // add 0index for x-axis & 1index for y-axis to get neighbour
    [-1, 1],// north west
    [0, 1], // north
    [1, 1], // north east


    [-1, 0], // west
    [1, 0], // east

    [-1, -1], // south west
    [0, -1], // south
    [1, -1] // south east
    ];

    $this->build_glider_pattern();
    $this->set_neighbours();
  }

  public function next_generation() {
    foreach ($this->cells as $cell) {
      $alive_neighbours = $this->alive_cell_neighbours($cell);
      if (!$cell->is_alive && $alive_neighbours == 3) {
        // alive 
        $cell->is_alive_in_next_generation = true;
      } else if ($alive_neighbours < 2 || $alive_neighbours > 3) {
        // dead RIP 
        $cell->is_alive_in_next_generation = false;
      } else {
        // same
        $cell->is_alive_in_next_generation = $cell->is_alive;
      }
    }

    foreach ($this->cells as $cell) {
      $cell->is_alive = $cell->is_alive_in_next_generation;
    }

  }


  private function build_glider_pattern() {
    for ($y = 0; $y <= $this->height; $y++) {
      for ($x = 0; $x <= $this->width; $x++) {
        $glider_pattern =  ["13.12","14.13","12.14","13.14","14.14"];
        if(in_array("$x.$y",$glider_pattern)) {
            $this->push_cell($x, $y, true);
        } else {
            $this->push_cell($x, $y, false);
        }
      }
    }
  }

  private function cell_neighbours($cell) {
    if ($cell->neighbours == null) {
      $cell->neighbours = array();
      foreach ($this->eight_directions as $dimensional) {
        $neighbour = $this->get_cell($cell->x + $dimensional[0],$cell->y + $dimensional[1]);
        if ($neighbour != null) {
          $cell->neighbours[] = $neighbour;
        }
      }
    }
    
    return $cell->neighbours;
  }

  private function set_neighbours() {
    foreach ($this->cells as $cell) {
      $this->cell_neighbours($cell);
    }
  }

  private function push_cell($x, $y, $is_alive = false) {

    $cell = new Cell($x, $y, $is_alive);
    $this->cells["$x.$y"] = $cell;
    return $this->get_cell($x, $y);
  }

  private function get_cell($x, $y) {
    if (isset($this->cells["$x.$y"])) {
      return $this->cells["$x.$y"];
    }
  }

  private function alive_cell_neighbours($cell) {
    $alive_neighbours = 0;
    $neighbours = $this->cell_neighbours($cell);
    foreach ($neighbours as $neighbour) {
      if ($neighbour->is_alive) {
        $alive_neighbours++;
      }
    }
    return $alive_neighbours;
  }

  public function draw() {
    $draw_universe = '';
    for ($y = 0; $y <= $this->height; $y++) {
      for ($x = 0; $x <= $this->width; $x++) {
        $cell = $this->get_cell($x, $y);
        $draw_universe .= $cell->draw();
      }
      $draw_universe .= "\n";
    }
    return $draw_universe;
  }

}

?>
