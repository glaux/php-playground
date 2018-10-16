<?php

namespace Triangle\Core;

use Triangle\Template\Page;

/**
 * Naming convention in the menu directory (env MENU_DIR):
 *   <weight>.<urlencoded_title>.<extensions>
 * if <weight> is _ the page is omitted from the menu.
 *
 * Note that ambiguous file names are possible. If more than one file in the
 * same directory has the same title (name minus order and extension), the first
 * of these files will be served with no warning.
 *
 * @see http://www.degraeve.com/reference/urlencoding.php
*/
class Router {

  static function create() {
    return new static;
  }

  function getFront() {
    $front = MenuItem::create()
      ->setTitle(getenv('SITE_TAGLINE'))
      ->setPath('pages/_.front.html')
    ;
    return $front;
  }

  function get404() {
    $error404 = MenuItem::create()
      ->setTitle('404 - Page not found')
      ->setPath('pages/_.404.html')
    ;
    return $error404;
  }

  function deliverPage() {
    return Page::create()
      ->setMenuItem($this->getMenuItem())
      ->build()
    ;
  }

  function getMenuItem() {

    // If no uri is found, return the front page
    $parts = $this->parseInputString();
    if ( empty($parts) ) {
      return $this->getFront();
    }

    // If we are on a subpage, search the menu tree
    $menu_item = $this->getMenuTree();
    while ( ! empty($parts) ) {
      $request = array_shift($parts);
      $child = $this->getMatchingChild($menu_item, $request);
      if ( ! empty($child) ) {
        $menu_item = $child;
      }
      else {
        // d('error: No valid page is found');
        return $this->get404();
      }
    }

    // If the last valid child is a directory, we deliver a 404.
    // This could be changed to a child listing in the future.
    if ( $menu_item->isDir() ) {
      // d('error: this is a directory');
      return $this->get404();
    }

    // This is just a sanity check, it should never be possible for resolveUrl()
    // to deliver a non-existing file, since it scans the directory on each run.
    if ( file_exists($menu_item->getPath()) ) {
      return $menu_item;
    }

    // d('error: the file doesn\'t exist!');
    return $this->get404();
  }

  /**
   * This has the side effect of making all slashes in the uri count as
   * exactly one.
   */
  function parseInputString() {
    $uri = urldecode(filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_STRING));
    return preg_split('%/%', $uri, null, PREG_SPLIT_NO_EMPTY);
  }

  function getMatchingChild(MenuItem $item, $request) {
    foreach ( $item as $child ) {
      if ( $request == $child->getTitle() ) {
        return $child;
      }
    }
  }

  function buildMenuTree($dir = null) {
    $items = scandir($dir);

    unset($items[array_search('.', $items, true)]);
    unset($items[array_search('..', $items, true)]);

    $r = [];

    // prevent empty ordered elements
    if ( count($items) < 1 ) {
      return $r;
    }

    foreach ( $items as $item ) {
      $parts = preg_split('%\.%', $item, null, PREG_SPLIT_NO_EMPTY);

      // pages enumerated with an underscore are ignored
      if ( $parts[0] === '_' ) {
        break;
      }

      $menu_item = MenuItem::create()
        ->setOrder((int) array_shift($parts))
        ->setPath($dir.'/'.$item)
      ;
      if ( $menu_item->isDir() ) {
        $menu_item->setChildren($this->buildMenuTree($menu_item->getPath()));
      }
      else {
        $menu_item->setExtension(array_pop($parts));
      }
      $menu_item->setTitle(join('.', $parts));

      $r[] = $menu_item;
    }

    return $r;
  }

  function getMenuTree() {
    // Create the top level item
    $menu_item = $this->get404()
      ->setChildren($this->buildMenuTree(getenv('MENU_DIR')))
    ;
    return $menu_item;
  }

}
