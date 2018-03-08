<?php
$ch = curl_init('http://'. $_SERVER['SERVER_NAME'] . str_replace("teste.php","",$_SERVER['REQUEST_URI']) .'abrirarq.php?arq='.'450-1136_Out_2017.txt');
$fp = fopen("example_homepage.txt", "w");

curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);

curl_exec($ch);
curl_close($ch);
fclose($fp);
unlink("example_homepage.txt");