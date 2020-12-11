<?php

Namespace Triangle\Template;

Use Triangle\Core\MenuItem;
Use Triangle\Core\Head;

class Page {

  protected $content = '';
  protected $menu_item;

  static function create() {
    return new self;
  }

  function setMenuItem(MenuItem $menu_item) {
    $this->menu_item = $menu_item;
    $this->loadContent();
    return $this;
  }

  function loadContent() {
    $filename = $this->menu_item->getPath();
    if ( file_exists($filename) ) {
      $stream = file_get_contents($filename);
      if ( $stream ) {
        $this->content = file_get_contents($filename);
        if ( $this->menu_item->getExtension() === 'php' ) {
          include $filename;
        }
      }
    }
  }

  public function build() {

    $head = Head::create()
      ->setPageName(join(' - ', [
        getenv('SITE_TITLE'),
        $this->menu_item->getPrettyName(),
      ]))
      ->build()
    ;
    $header = Header::create()->build();
    $footer = Footer::create()->build();

$html = <<<HTML

<!DOCTYPE html>
<html>

<head>
  $head
</head>

<body>

  <div class="background">
    <div class="sheet hue-rotate">
      $header
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


//     $html = <<<HTML

// <!DOCTYPE html>
// <html>

//   <head>
//     $head
//   </head>

//   <body>
//     <header>
//       $header
//     </header>
//     <main>
//       $this->content
//     </main>
//     <footer>
//       $footer
//     </footer>
//   </body>

// </html>

// HTML;

    return $html;
  }
}


// <div class="parallax-group">
//   $this->content
// </div>



// <div class="background">
//     <div class="sheet">
//       <!--$menu-->
//       <div class="content">
//         <div class="contentContainer">

//         </div>
//       </div>
//       <!--$footer-->
//     </div>
//   </div>
