<?php

/**
 * An example of a project-specific implementation.
 *
 * After registering this autoload function with SPL, the following line
 * would cause the function to attempt to load the \Triangle\Baz\Qux class
 * from /path/to/project/src/Baz/Qux.php:
 *
 *      new \Triangle\Baz\Qux;
 *
 * @param string $class The fully-qualified class name.
 * @return void
 */
class CustomAutoloader {

  const PROJECT_NAMESPACE = 'Triangle\\';
  const BASE_DIR = __DIR__ . '/../src/';

  public function register($class_name) {
    // does the class use the namespace prefix?
    $len = strlen(self::PROJECT_NAMESPACE);
    if ( strncmp(self::PROJECT_NAMESPACE, $class_name, $len) !== 0 ) {
      // no, move to the next registered autoloader
      return;
    }

    // get the relative class name
    $relative_class = substr($class_name, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = self::BASE_DIR . str_replace('\\', '/', $relative_class) . '.php';
    $this->requireFile($file);
  }

  public function requireFile($file) {
    // if the file exists, require it
    if ( file_exists($file) ) {
      require $file;
    }
    /*else {
      print('File does not exist!');
    }*/
  }
}

// Add the autoloader to the SPL register
$autoloader = new CustomAutoloader;
spl_autoload_register([$autoloader, 'register']);
