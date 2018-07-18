<?php
/**
 * Description of tarefas
 *
 * @author tiagoc
 */
class Tarefas{
    function getTelas($_url , $_nome){        
        //This is the file where we save the    information
        $fp = fopen ("..". "/images/temp/$_nome", 'w+');
        //Here is the file we are downloading, replace spaces with %20
        $ch = curl_init(str_replace(" ","%20",$_url));
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        // write curl response to file
        curl_setopt($ch, CURLOPT_FILE, $fp); 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // get curl response
        curl_exec($ch); 
        curl_close($ch);
        fclose($fp);  
    }
}