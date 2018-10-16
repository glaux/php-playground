<?php

namespace Triangle\Core;

class HTML {

  protected $tag = 'p';
  protected $props = [];

  static function create() {
    return new static;
  }

  function tag($tag) {
    $this->tag = $tag;
    return $this;
  }

  function props($props) {
    $this->props = $props;
    return $this;
  }

  function wrap($string) {
    $r['open'] = '<' . $this->tag . ' ' . $this->joinProps() . '>';
    $r['string'] = $string;
    $r['close'] = '</' . $this->tag . '>';
    return join('', $r);
  }

  function single() {
    return '<' . $this->tag . ' ' . $this->joinProps() . '/>';
  }

  function joinProps() {
    // @see https://stackoverflow.com/questions/11427398/ -
    // This above doesn't work with spaces in the file name:
    // $props = urldecode(http_build_query($this->props, '', ', '));
    // We loop manually instead

    $props = $this->props;
    foreach ( $this->props as $key => $value ) {
      $props[$key] = $key . '=' . '"' . $value . '"';
    }
    return join(' ', $props);
  }
}
