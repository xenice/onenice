<?php

namespace xenice\util;

use xenice\theme\Space;

require __DIR__ . '/RSAUtils.php';

class Rsa
{
    private $keys = [
        'default'=>
            [
                'privateKey'=>'',
                'publicKey'=>'',
            ]
    ];
    
    public function __construct()
    {

    }
    
    public function setKeys($privateKey, $publicKey)
    {
        $this->keys['default']['privateKey'] = $privateKey;
        $this->keys['default']['publicKey'] = $publicKey;
    }
    
    public function keypair()
    {
        return RSAUtils::resetGenKeyPair();
    }
    
    // 私钥加密
    public function encryptPrivateKey($data, $privateKey)
    {
        return $this->encodeSaleUrl(RSAUtils::encryptByPrivateKey($data, $privateKey));
    }
    
    // 公钥解密
    public function decryptPublicKey($data, $publicKey)
    {
        return RSAUtils::decryptByPublicKey($this->decodeSaleUrl($data), $publicKey);
    }
    
    // 公钥加密
    public function encryptPublicKey($data, $publicKey)
    {
        return $this->encodeSaleUrl(RSAUtils::encryptByPublicKey($data, $publicKey));
    }
    
    // 私钥解密
    public function decryptPrivateKey($data, $privateKey)
    {
        return RSAUtils::decryptByPrivateKey($this->decodeSaleUrl($data), $privateKey);
    }
    
    
    // 私钥加密 key
    public function encodePrivateKey($data, $key = 'default')
    {
        $privateKey = $this->keys[$key]["privateKey"];
        return $this->encryptPrivateKey($data, $privateKey);
    }
    
    // 公钥解密 key
    public function decodePublicKey($data, $key = 'default')
    {
        $publicKey = $this->keys[$key]["publicKey"];
        return $this->decryptPublicKey($data, $publicKey);
    }
    
    // 公钥加密 key
    public function encodePublicKey($data, $key = 'default')
    {
        $publicKey = $this->keys[$key]["publicKey"];
        return $this->encryptPublicKey($data, $publicKey);
    }
    
    // 私钥解密 key
    public function decodePrivateKey($data, $key = 'default')
    {
        $privateKey = $this->keys[$key]["privateKey"];
        return $this->decryptPrivateKey($data, $privateKey);
    }
    
    public function encodeSaleUrl($data) 
	{ 
  		return rtrim(strtr($data, '+/', '-_'), '='); 
	} 
	
	public function decodeSaleUrl($data)
	{ 
  		return str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT); 
	}
}