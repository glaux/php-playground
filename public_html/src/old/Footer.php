<?php

namespace PLAY;

class Footer {

  public static function create() {
    return new self;
  }

  public function getCorrectMTime($filePath) {
    $time = filemtime($filePath);

    $isDST = (date('I', $time) == 1);
    $systemDST = (date('I') == 1);

    $adjustment = 0;

    if ( $isDST == false && $systemDST == true ) {
      $adjustment = 3600;
    }

    else if ( $isDST == true && $systemDST == false ) {
      $adjustment = -3600;
    }

    else {
      $adjustment = 0;
    }

    return ( $time + $adjustment );
  }

  public function updated() {
    if ( empty($_SESSION['template']) ) {
      $thisfilename = $_SERVER['PHP_SELF'];
      preg_match('%\/([^\/]+).php%', $thisfilename, $kode);
      $filename = $kode[1].'.php';
    }
    else {
      $filename = $_SESSION['template'];
    }
    if ( file_exists($filename) ) {
      $updated = date("j.n.Y", $this->getCorrectMTime($filename)); // H:i:s
    }
    else {
      $updated = 'never';
    }

    return $updated;
  }

  public function build() {

    $updated = $this->updated();

    $footer = <<<HTML

<div class="footer">
  <div class="footerbox">

    <ul class="footernavigation">
      <li>
        <p>
            <span style="padding: 0 14px;">PHP playground</span>
          | <span style="padding: 0 14px;">Test and ideas</span>
          | <span style="padding: 0 14px;">Last updated: $updated</span>

        </p>
      </li>
    </ul>

  </div>
</div>
HTML;

    return $footer;
  }

}
