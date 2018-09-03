<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件




/**
 * curl
 * @param $url
 * @param null $data
 * @param string $method
 * @return mixed
 * @throws Exception
 */
function curl($url, $data = null, $method = 'post') {

    $req_str = '';
    if (is_array($data)) {
        $req_str = http_build_query($data);
    } else {
        $req_str = $data;
    }

    if ($method != 'post' && $data) {
        $url .= '?' . $req_str;
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 180);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36');

    if ($method == 'post') {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req_str);
    }

    $res = curl_exec($ch);
    $resCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if (($resCode > 399 && $resCode < 500) || $err_no = curl_errno($ch)) {

        throw new \Exception(sprintf("curl失败，远程请求错误，返回代码：%s，错误描述：%s", $resCode ,curl_error($ch)));

    }
    curl_close($ch);
    return $res;

}

function p($arr) {
    echo '<pre />';
    print_r($arr);
    echo '<pre />';
}

function user_md5($str, $auth_key = '')
{
    return '' === $str ? '' : md5(sha1($str) . $auth_key);
}
/**
 * cookies加密函数
 * @param string 加密后字符串
 */
function encrypt($data, $key = 'kls8in1e')
{
    $prep_code = serialize($data);
    $block = @mcrypt_get_block_size('des', 'ecb');
    if (($pad = $block - (strlen($prep_code) % $block)) < $block) {
        $prep_code .= str_repeat(chr($pad), $pad);
    }
    $encrypt = @mcrypt_encrypt(MCRYPT_DES, $key, $prep_code, MCRYPT_MODE_ECB);
    return base64_encode($encrypt);
}

/**
 * cookies 解密密函数
 * @param array 解密后数组
 */
function decrypt($str, $key = 'kls8in1e')
{
    $str = base64_decode($str);
    $str = @mcrypt_decrypt(MCRYPT_DES, $key, $str, MCRYPT_MODE_ECB);
    $block = @mcrypt_get_block_size('des', 'ecb');
    $pad = ord($str[($len = strlen($str)) - 1]);
    if ($pad && $pad < $block && preg_match('/' . chr($pad) . '{' . $pad . '}$/', $str)) {
        $str = substr($str, 0, strlen($str) - $pad);
    }
    return unserialize($str);
}