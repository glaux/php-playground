<?php

require 'vendor/kint.php';
require 'vendor/autoload.php';
// phpinfo();
echo Triangle\Core\Router::create()->deliverPage();


// echo 'php';


// # Include the Autoloader (see "Libraries" for install instructions)
// require 'vendor/autoload.php';
// use Mailgun\Mailgun;
// # Instantiate the client.
// $mgClient = new Mailgun('e1bf7fe87334652dd01a9c30e1a5cd2f-f877bd7a-fc2a70c9');
// $domain = "YOUR_DOMAIN_NAME";
// # Make the call to the client.
// $result = $mgClient->sendMessage($domain, array(
// 	'from'	=> 'Excited User <mailgun@YOUR_DOMAIN_NAME>',
// 	'to'	=> 'Baz <YOU@YOUR_DOMAIN_NAME>',
// 	'subject' => 'Hello',
// 	'text'	=> 'Testing some Mailgun awesomness!'
// ));























// $data = array(
//     'token' => 'DC71E58DED9F29A9F59EC14FACCED4C6',
//     'content' => 'project',
//     'format' => 'json',
//     'returnFormat' => 'json'
// );

// $postdata = http_build_query($data);
// d($postdata);

// $opts = array('http' =>
//   array(
//     'method'  => 'POST',
//     'header'  => 'Content-type: application/x-www-form-urlencoded',
//     'content' => $postdata
//   )
// );
// $context  = stream_context_create($opts);
// $result = file_get_contents('https://redcap.au.dk/api/', false, $context);
// d($result);























// $data = array(
//     'token' => 'DC71E58DED9F29A9F59EC14FACCED4C6',
//     'content' => 'project',
//     'format' => 'json',
//     'returnFormat' => 'json'
// );
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, 'https://redcap.au.dk/api/');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($ch, CURLOPT_VERBOSE, 0);
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
// curl_setopt($ch, CURLOPT_AUTOREFERER, true);
// curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
// curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
// curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data, '', '&'));
// $output = curl_exec($ch);
// print $output;
// curl_close($ch);

// print '3333';








// $r = function($a) {
//   while ($a) do {
//     $c = array_shift($a);

//   }
// }

// echo $r(str_split('6a4'));


// echo 'Hello World!';
// echo getenv('TEST_VAR__') ?? 'missing';
// d(getenv('TEST_VAR__'));


// echo '<br />';


// echo false ? '' : '1234567';




// $a=str_split('6a4');
// $i=0;
// while($a){
//   $c=hexdec(array_shift($a));
//   echo str_repeat($i,$c);
//   $i=$i?0:1;
// }
// 93 chars uden streng



// $a=str_split('6a4');$i=0;while($a){$c=hexdec(array_shift($a));echo str_repeat($i,$c);$i=$i?0:1;}
