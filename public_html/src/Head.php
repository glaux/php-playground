<?php

namespace PLAY;

class Head {

  protected $page_name = '';

  public function setPageName($name) {
    $this->page_name = $name;
    return $this;
  }

  public static function create() {
    return new self;
  }

  public function build() {
    $title = '<title>'.$this->page_name.'</title>';
    $styles = '<link rel="stylesheet" type="text/css" href="css/styles.css" />';
    $scripts = '<script type="text/javascript" src="js/script.js" /></script>';
    $meta = '<meta charset=utf-8" />';

    $head = $title.$styles.$scripts.$meta;

    return $head;
  }
}
