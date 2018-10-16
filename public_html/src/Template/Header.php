<?php

Namespace Triangle\Template;

Use Triangle\Core\Menu;

class Header {

  const FILE_NAME = 'pages/_.header.html';

  static function create() {
    return new self;
  }

  function build() {
    $r = [];
    if ( file_exists(self::FILE_NAME) ) {
      $stream = file_get_contents(self::FILE_NAME);
      if ( $stream ) {
        $r['static_content'] = file_get_contents(self::FILE_NAME);
      }
    }

    $r['menu'] = Menu::create()->build();

    $menu = join('', $r);

    $header = <<<HTML

<div class="header"></div>
<div class="menu">
  $menu
</div>
HTML;

  return $header;

  }
}
