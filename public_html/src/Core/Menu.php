<?php

namespace Triangle\Core;

class Menu {

  static function create() {
    return new self;
  }

  function build() {
    return HTML::create()
      ->tag('nav')
      ->props(['role' => 'navigation'])
      ->wrap($this->printMenuTree())
    ;
  }

  function printMenuTree() {
    $menu_tree = Router::create()->getMenuTree();
    return HTML::create()
      ->tag('ul')
      ->wrap($this->recurse($menu_tree))
    ;
  }

  function recurse($menu_tree) {
    $r = [];

    foreach ( $menu_tree as $menu_item ) {
      if ( $menu_item->isDir() ) {
        $t = [];
        // Replace the fake link with a real one if _.content.html is implemented
        $t['fake_link'] = HTML::create()
          ->tag('a')
          ->wrap($menu_item->getPrettyName())
        ;
        $t['subtree'] = HTML::create()
          ->tag('ul')
          ->wrap($this->recurse($menu_item))
        ;
        $t = join('', $t);
      }
      else {
        $t = HTML::create()
          ->tag('a')
          ->props([
            'href' => $menu_item->getPrettyUrl(),
          ])
          ->wrap($menu_item->getPrettyName())
        ;
      }
      $li = HTML::create()->tag('li');
      if ( $menu_item->isOnCurrentPath() ) {
        $li->props(['class' => 'current']);
      }

      $r[] = $li->wrap($t);

    }

    return join('', $r);
  }

}
