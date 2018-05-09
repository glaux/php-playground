<?php

require 'vendor/kint.php';
require 'vendor/autoload.php';

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

// Defaults
$content = file_get_contents('pages/_.front.html');
$title = 'PHP playgrond';

// Compute specific values
$filename = 'pages/' . $_GET['pageid'];
if ( file_exists($filename) ) {
  $stream = file_get_contents($filename);
  if ( $stream ) {
    $content = file_get_contents($filename);
    $parts = explode('.', $_GET['pageid']);
    $ext = array_pop($parts);
    if ( $ext === 'php' ) {
      include $filename;
    }
    $sub_title = PLAY\Menu::create()->getDisplayName( '-.' . array_pop($parts) . '.' . $ext);
    $title .= ' - ' . $sub_title;
  }
}

// TODO: 404 pages set up with apache conf along with clean urls.

// Deliver the page
echo PLAY\Page::create()
  ->setPageName($title)
  ->setContent($content)
  ->build()
;
