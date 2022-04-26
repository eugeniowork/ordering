<?php
	function encryptData($params){
		$key = "ORDERING";
        $options = 0; 
        $encryption_iv = '1234567891011121'; 
        return bin2hex(openssl_encrypt($params,'AES-128-CBC', $key,$options,$encryption_iv));	
	}

	function decryptData($params){
		$key = "ORDERING";
        $options = 0; 
        $decryption_iv = '1234567891011121'; 
        return openssl_decrypt(hex2bin($params),'AES-128-CBC',$key,$options,$decryption_iv);
	}

?>