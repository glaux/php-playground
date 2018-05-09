<?php

Namespace PLAY;

class Link {

  public static function get($pageid, $text) {
    return '<a href="?pageid=' . urlencode($pageid) .'">' . $text . '</a>';
  }
}


