<?PHP

/**
 * @since  2013-12-11
 * @AES256λ����
 * @modified 16-01-2014
 * @copyright 2013 - 2015 Tianye
 **/
class Libs_AES126{
    static public $mode = MCRYPT_MODE_ECB;

    public  function encrypt($input,$key) {
        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $input = $this->pkcs5_pad($input, $size);
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $key, $iv);
        $data = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = base64_encode($data);
        return $data;
    }
//    private  function pkcs5_pad ($text, $blocksize) {
//        $pad = $blocksize - (strlen($text) % $blocksize);
//        return $text . str_repeat(chr($pad), $pad);
//    }
//    public  function decrypt($sStr,$key) {
//        $decrypted= mcrypt_decrypt(
//            MCRYPT_RIJNDAEL_128,
//            $key,
//            base64_decode($sStr),
//            MCRYPT_MODE_ECB
//        );
//        $dec_s = strlen($decrypted);
//        $padding = ord($decrypted[$dec_s-1]);
//        $decrypted = substr($decrypted, 0, -$padding);
//        return $decrypted;
//    }

    /* 解密
        php  AES加密后不会在字符串后面补位x00和记位符
        ios 和 java(android)
    */
    function decrypt($string,$key){
        if(empty($string)){
            return FALSE;
        }
        $decrypted =  mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($string), MCRYPT_MODE_ECB);
        return $this->pkcs5_unpad($decrypted);
    }

    function pkcs5_pad($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    function pkcs5_unpad($text) {
        $pad = ord($text{strlen($text)-1});
        if ($pad > strlen($text)) return false;
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return false;
        return substr($text, 0, -1 * $pad);
    }


//    function encrypt($input,$key)
//    {
//        $size = mcrypt_get_block_size('des', 'ecb');
//        $input = $this->pkcs5_pad($input, $size);
//        $td = mcrypt_module_open('des', '', 'ecb', '');
//        $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
//        mcrypt_generic_init($td, $key, $iv);
//        $data = mcrypt_generic($td, $input);
//        mcrypt_generic_deinit($td);
//        mcrypt_module_close($td);
//        $data = base64_encode($data);
//        return $data;
//    }
//
//    function pkcs5_pad ($text, $blocksize)
//    {
//        $pad = $blocksize - (strlen($text) % $blocksize);
//        return $text . str_repeat(chr($pad), $pad);
//    }
//
//    function pkcs5_unpad($text)
//    {
//        $pad = ord($text{strlen($text)-1});
//        if ($pad > strlen($text)) return false;
//        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return false;
//        return substr($text, 0, -1 * $pad);
//    }

}
