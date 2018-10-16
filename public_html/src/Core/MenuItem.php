<?php

namespace Triangle\Core;

class MenuItem implements \Iterator {

  protected $order = 0;
  protected $extension = '';
  protected $children = [];
  protected $title = '';
  protected $path = '';

  static function create() {
    return new static;
  }

  function setOrder($order) {
    $this->order = $order;
    return $this;
  }

  function getOrder() {
    return $this->order;
  }

  function setExtension($extension) {
    $this->extension = $extension;
    return $this;
  }

  function getExtension() {
    return $this->extension;
  }

  function addChild(MenuItem $child) {
    $this->children[$child->getOrder()] = $child;
    return $this;
  }

  function setChildren(array $children) {
    $this->children = $children;
    return $this;
  }

  function isDir() {
    if ( is_dir($this->getPath()) ) {
    // }
    // if ( ! empty($this->children) ) {
      return true;
    }
    return false;
  }

  function setTitle($title) {
    $this->title = $title;
    return $this;
  }

  function getTitle() {
    return $this->title;
  }

  function setPath($path) {
    $this->path = $path;
    return $this;
  }

  function getPath() {
    return $this->path;
  }

  function getPrettyName() {
    return ucfirst(preg_replace('%_%', ' ', urldecode($this->getTitle())));
  }

  /**
   * Create a pretty uri from the real path
   */
  function getPrettyUri() {
    $len = strlen(getenv('MENU_DIR'));
    $ugly_uri = substr($this->getPath(), $len);
    $parts = preg_split('%/%', $ugly_uri, null, PREG_SPLIT_NO_EMPTY);
    end($parts);
    $last_key = key($parts);
    foreach ( $parts as $key => &$part ) {
      $part = preg_split('%\.%', $part, null, PREG_SPLIT_NO_EMPTY);
      array_shift($part);
      if ( $key === $last_key ) {
        array_pop($part);
      }
      $part = join('.', $part);
    }
    return '/' . join('/', $parts);
  }

  function getPrettyUrl() {
    // Do NOT use urlencode here, it does not behave as you'd expect
    return 'http://' . $_SERVER['HTTP_HOST'] . $this->getPrettyUri();
  }

  // This function only gets the current leaf item at the moment.
  function isOnCurrentPath() {
    $uri = urldecode(filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_STRING));
    if ( $uri == $this->getPrettyUri() ) {
      return true;
    }
  }

  // Iterator methods
  private $position = 0;

  function current () {
    return $this->children[$this->position];
  }
  function key () {
    return $this->position;
  }
  function next () {
    // while ( ! in_array(key($this->children), [$this->position, null])) {
    //   next($this->children);
    // }
    // if ( current($this->children) !== false ) {
    //   // We found the key and set the pointer!
    //   $this->position = key($this->children);
    // }
    ++$this->position;
  }
  function rewind () {
    // reset($this->children);
    // $this->position = key($this->children);
    $this->position = 0;
  }
  function valid () {
    return isset($this->children[$this->position]);
  }

}

