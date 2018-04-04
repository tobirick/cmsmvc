<?php

namespace Core;

class Shortcode {
  public function call($array) {
    $methodName = $array[0];
    $methodParams = '';

    for($i = 1; $i < sizeof($array); $i++) {
      $methodParams .= $array[$i];
      if(sizeof($array) !== $i + 1) {
        $methodParams .= ' ';
      }
    }

    return CustomShortcodes::$methodName($methodParams);
  }
}