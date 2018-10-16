<?php

Namespace PLAY;

Use PLAY\Menu;
Use PLAY\Footer;

class Page {

  protected $page_name = '';

  protected $content = '';

  public function setPageName($name) {
    $this->page_name = $name;
    return $this;
  }

  public function setContent($html) {
    $this->content = $html;
    return $this;
  }

  public static function create() {
    return new self;
  }

  public function build() {

    $head = Head::create()
      ->setPageName($this->page_name)
      ->build()
    ;
    $menu = Menu::create()->build();
    $footer = Footer::create()->build();

    $html = <<<HTML

<!DOCTYPE html>
<html>

<head>
  $head
</head>

<body>

  <div class="background">
    <div class="sheet">
      $menu
      <div class="content">
        <div class="contentContainer">
          $this->content
        </div>
      </div>
      $footer
    </div>
  </div>

</body>
</html>
HTML;

    return $html;
  }
}


