<?php
/**
 * Custom global functions
 */

if(!function_exists('curl_request')){

    /**
     * @param $url
     * @param string $method
     * @param array $data
     * @return mixed
     */
    function curl_request($url , $method='PUT' ,$data=[]){
        $method = strtoupper($method);
        $ch = curl_init();
        curl_setopt($ch , CURLOPT_URL ,$url);
        curl_setopt($ch , CURLOPT_SSL_VERIFYPEER ,false);
        curl_setopt($ch , CURLOPT_SSL_VERIFYHOST ,$url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if(!empty($data)){
            curl_setopt($ch,CURLOPT_POSTFIELDS ,$data);
        }
        curl_setopt($ch,CURLOPT_RETURNTRANSFER , 1);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
}