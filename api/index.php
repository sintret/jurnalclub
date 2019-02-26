<?php

define('__ROOT__', dirname(dirname(__FILE__)));
$path = str_replace('plugins\generic\jurnalclub', '', __ROOT__);

include(__ROOT__ . '/api/adodb/adodb.inc.php');

$configPath = $path . 'config.inc.php';
$myfile = fopen($configPath, "r") or die("Unable to open file!");
$config = fread($myfile, filesize($configPath));
fclose($myfile);

$array = explode("[database]", $config);
$con = explode("[cache]", $array[1]);
$content = explode("\n", $con[0]);

$credentials = array();

foreach ($content as $arr) {
    $trim = trim($arr);

    if (strpos($trim, '=') !== false) {

        $myexplode = explode("=", $trim);
        $key = trim($myexplode[0]);
        $value = trim($myexplode[1]);

        $credentials[$key] = $value;
    }
}

/*
 * Array
  (
  [driver] => mysqli
  [host] => localhost
  [username] => root
  [password] =>
  [name] => kampret
  [persistent] => Off
  [debug] => Off
  )
 */

/*
 * connection to database
 */
$db = adoNewConnection($credentials['driver']); # eg. 'mysqli' or 'oci8'
$db->debug = false;
$db->connect($credentials['host'], $credentials['username'], $credentials['password'], $credentials['name']);
/*
 * $rs = $db->execute('select * from some_small_table');
  print "<pre>";
  print_r($rs->getRows());
  print "</pre>";
 */

$json = [
    'status' => 1,
    'title' => 'Success',
    'message' => 'Successfully updated!'
];

if (isset($_POST['type'])) {
    $type = $_POST['type'];

    if ($type == 'register') {
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        $bindVars = array($phone, $email);
        $sql = 'UPDATE `users` SET `phone` = ? WHERE `email` = ? ';
        $rs = $db->execute($sql, $bindVars);
    } else if ($type == "token") {

        $token = $_POST['token'];
        if ($token) {
            $tokenPath = __ROOT__ . '\token.txt';
            $myfile = fopen($tokenPath, "w");
            fwrite($myfile, $token);
            fclose($myfile);
        }
    }


    echo json_encode($json);
}
//
//$phone = '64543535311';
//$email = 'alcytrite@gmail.com';
//
//$bindVars = array($phone, $email);
//$sql = 'UPDATE `users` SET `phone` = ? WHERE `email` = ? ';
//$rs = $db->execute($sql, $bindVars);
//
//print "<pre>";
//print_r($rs->getRows());
//print "</pre>";


