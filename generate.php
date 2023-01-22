<?php

require_once('Universe.php');

class Generate {


  public static function universe() {
    $universe = new Universe();


    $screen = 0;
    while (true) {
      $screen++;
      $universe->next_generation();
      $draw = $universe->draw();
      $universe_output = "Genearation : ".$screen."\n".$draw;
      sleep(2);
      echo $universe_output;
    }
  }

}

Generate::universe();

?>
