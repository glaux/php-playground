<?php

namespace Triangle\Core;


/**
 * CSS and JS are loaded from their respective directories defined in the
 * environment variables. These are loaded in alfabetically, so if order
 * matters, rename the files, for example by prefixing numbers.
 *
 * This direct method of embedding has no cache so performance might suffer a
 * bit. However this method requires no watch scripting and is very simple.
 */
class Head {

  protected $page_name = '';

  public static function create() {
    return new self;
  }

  function setPageName($name) {
    $this->page_name = $name;
    return $this;
  }

  // function loadJs() {
  //   $files = scandir(getenv('JS_DIR'));
  //   unset($files[array_search('.', $files, true)]);
  //   unset($files[array_search('..', $files, true)]);

  //   $js = [];

  //   foreach ( $files as $filename ) {
  //     $filename = getenv('JS_DIR') . '/' . $filename;
  //     if ( file_exists($filename) ) {
  //       $stream = file_get_contents($filename);
  //       if ( $stream ) {
  //         $js[] = $stream;
  //       }
  //     }
  //   }

  //   return join(PHP_EOL, $js);
  // }

  // function loadCss() {
  //   $files = scandir(getenv('CSS_DIR'));
  //   unset($files[array_search('.', $files, true)]);
  //   unset($files[array_search('..', $files, true)]);

  //   $css = [];

  //   foreach ( $files as $filename ) {
  //     $filename = getenv('CSS_DIR') . '/' . $filename;
  //     if ( file_exists($filename) ) {
  //       $stream = file_get_contents($filename);
  //       if ( $stream ) {
  //         $css[] = $stream;
  //       }
  //     }
  //   }

  //   return join(PHP_EOL, $css);
  // }

  function loadfromDir($dir) {
    $files = scandir($dir);
    unset($files[array_search('.', $files, true)]);
    unset($files[array_search('..', $files, true)]);

    $r = [];

    foreach ( $files as $filename ) {
      $filename = $dir . '/' . $filename;
      if ( file_exists($filename) ) {
        $stream = file_get_contents($filename);
        if ( $stream ) {
          $r[] = $stream;
        }
      }
    }

    return join(PHP_EOL, $r);
  }

  function build() {
    $r = [];

    $r[] = HTML::create()
      ->tag('title')
      ->wrap($this->page_name)
    ;

    // jQuery
    // $r[] = HTML::create()
    //   ->tag('script')
    //   ->props([
    //     'type'        => 'text/javascript',
    //     'src'         => 'https://code.jquery.com/jquery-3.3.1.min.js',
    //     // 'src'         => 'https://code.jquery.com/jquery-3.3.1.slim.min.js',
    //     // 'integrity'   => 'sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E=',
    //     // 'crossorigin' => 'anonymous',
    //   ])
    //   ->wrap('')
    // ;

    // $r[] = HTML::create()
    //   ->tag('script')
    //   ->props([
    //     'type' => 'text/javascript',
    //     'src'  => '/js/jquery.slicknav.js',
    //   ])
    //   ->wrap('')
    // ;

    // $r[] = HTML::create()
    //   ->tag('script')
    //   ->props([
    //     'type' => 'text/javascript',
    //     'src'  => '/js/script.js',
    //   ])
    //   ->wrap('')
    // ;

    $r[] = HTML::create()
      ->tag('script')
      ->props([
        'type' => 'text/javascript',
      ])
      ->wrap($this->loadfromDir(getenv('JS_DIR')))
    ;

    $r[] = HTML::create()
      ->tag('style')
      ->props([
        'type' => 'text/css',
      ])
      ->wrap($this->loadfromDir(getenv('CSS_DIR')))
    ;

    // $r[] = HTML::create()
    //   ->tag('link')
    //   ->props([
    //     'rel'  => 'stylesheet',
    //     'type' => 'text/css',
    //     'href' => '/css/styles.css',
    //   ])
    //   ->single()
    // ;

    $r[] = HTML::create()
      ->tag('link')
      ->props([
        'type' => 'text/css',
        'rel'  => 'stylesheet',
        'href' => 'https://fonts.googleapis.com/css?family=Roboto:100,300,400',
      ])
      ->single()
    ;

    $r[] = HTML::create()
      ->tag('meta')
      ->props([
        'name'    => 'viewport',
        'content' => 'width=device-width, initial-scale=1',
      ])
      ->single()
    ;

    $r[] = HTML::create()
      ->tag('meta')
      ->props([
        'charset' => 'utf-8',
      ])
      ->single()
    ;

    return join(PHP_EOL, $r);
  }
}
