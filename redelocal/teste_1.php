<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

$url = 'http://10.24.0.59/zabbix/index.php';
$data = 'name=redmine&password=74123698seed&autologin=1&enter=Sign+in';
$s = "http://10.24.0.59/zabbix/map.php?noedit=1&sysmapid=527&width=500&height=100&curtime=1537442566&severity_min=0";

$rotina->login($url, $data, "zabbix_seed");

$rotina->grab_page($s,"teste_tiago2.png","zabbix_seed");
//
//$rotina->login($url2, $data, "zabbix_cofre");
//
//$rotina->grab_page($s2,"teste_tiago.png","zabbix_cofre");
//
//
//$urlExp = "https://expresso.se.gov.br/login.php";
//$dadosExp = "certificado=&passwd_type=text&account+type=u&login=tiago.costa&user=tiago.costa&passwd=81327012%40&submitit=Conectar";
$sistExp = "expresso";
//$rotina->login($urlExp, $dadosExp, $sistExp);
$s2 = "https://expresso.se.gov.br/expressoMail1_2/index.php?msgball[msgnum]=18337&msgball[folder]=INBOX";
//
//$rotina->grab_page($s2,"teste_tiago.html",$sistExp);


//set the directory for the cookie using defined document root var

//build a unique path with every request to store 
//the info per user with custom func. 

//login form action url
$url="https://expresso.se.gov.br/login.php"; 
$postinfo = "certificado=&passwd_type=text&account+type=u&login=tiago.costa&user=tiago.costa&passwd=81327012%40&submitit=Conectar";

$cookie_file_path = "../temp/$sistExp.txt";

$ch = curl_init();
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_NOBODY, false);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
//set the cookie the site has for certain features, this is optional
curl_setopt($ch, CURLOPT_COOKIE, "cookiename=0");
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_REFERER, $_SERVER['REQUEST_URI']);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postinfo);
curl_exec($ch);

//page with the content I want to grab
curl_setopt($ch, CURLOPT_URL, $s2);

//do stuff with the info with DomDocument() etc
echo curl_exec($ch);
curl_close($ch);
