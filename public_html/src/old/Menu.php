<?php

namespace PLAY;

Use PLAY\Link;

class Menu {

  const MENU_DIR = __DIR__ . '/../pages';

  public static function create() {
    return new self;
  }

  // Naming:
  // <weight>.<urlencoded_title>.<extensions>
  // if <weight> is _ the page i omitted from the menu
  // http://www.degraeve.com/reference/urlencoding.php

  public function buildArray($dir) {
    $items = scandir($dir);

    unset($items[array_search('.', $items, true)]);
    unset($items[array_search('..', $items, true)]);

    // prevent empty ordered elements
    if ( count($items) < 1 ) {
      return;
    }

    $result = [];
    foreach ( $items as $item ) {
      $parts = explode('.', $item);
      if ( $parts[0] === '_' ) {
        break;
      }
      $result[(int) $parts[0]] = $item;
      if ( is_dir($dir.'/'.$item) ) {
        $result[$parts[0]] = $this->buildArray($dir.'/'.$item);
        $result[$parts[0]]['title'] = $item;
      }
    }

    return $result;
  }

  /*public function listFolderFiles($dir) {
    $ffs = scandir($dir);

    unset($ffs[array_search('.', $ffs, true)]);
    unset($ffs[array_search('..', $ffs, true)]);

    // prevent empty ordered elements
    if ( count($ffs) < 1 ) {
      return;
    }

    echo '<ol>';
    foreach($ffs as $ff){
      echo '<li>'.$ff;
      if ( is_dir($dir.'/'.$ff) ) {
        $this->listFolderFiles($dir.'/'.$ff);
      }
      echo '</li>';
    }
    echo '</ol>';
  }*/

  public function getDisplayName($machine_name) {
    $parts = explode('.', $machine_name);
    return ucfirst(preg_replace('/_/', ' ', urldecode($parts[1])));
  }

  public function buildUlStructure($arr = [], $path = '') {
    $r = '';
    foreach ( $arr as $key => $value ) {
      $r .= '<li>';
      if ( is_array($value) ) {
        $r .= '<a onclick="" class="menu-header">';
        $r .= $this->getDisplayName($value['title']);
        $r .= '</a>';
        $new_path = $path.'/'.$value['title'];
        unset($value['title']);
        $r .= '<ul>';
        $r .= $this->buildUlStructure($value, $new_path);
        $r .= '</ul>';
      }
      else {
        $r .= Link::get($path.'/'.$value, $this->getDisplayName($value));
      }
      $r .= '</li>';
    }

    return $r;
  }

  public function build() {
    $arr = $this->buildArray(self::MENU_DIR);
    $ul_structure = $this->buildUlStructure($arr);

    /*d($arr);
    d($ul_structure);*/

    $menu = <<<HTML

<div class="header"></div>
<div class="menu">
  <div class="menubox">
    <ul class="menunavigation">
      $ul_structure
    </ul>
  </div>
</div>
HTML;

  return $menu;

  }
}
