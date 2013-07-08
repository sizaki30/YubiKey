<?php
ini_set('error_reporting', ini_get('error_reporting') & ~E_STRICT);
require_once 'Auth_Yubico-2.4/Yubico.php';

// API Client ID
$id = '＜Client ID＞';

// API Secret key
$key = '＜Secret key＞';

// SSL通信 true:する false:しない
$https = true;

// YubiKey ワンタイムパスワード
$otp = $_POST['otp'];

// YubiKey ID
$yubikeyID = substr($otp, 0, 12);

// 認証処理
$yubi = new Auth_Yubico($id, $key, $https);
$auth = $yubi->verify($otp);

// 認証結果
$mesg = "<p>YubiKey ID：{$yubikeyID}</p>\n";
if (PEAR::isError($auth)) {
    $mesg .= "<p>認証：NG</p>\n";
    $mesg .= "<p>エラーメッセージ：" . $auth->getMessage() . "</p>\n";
} else {
    $mesg .= "<p>認証：OK</p>\n";
}

// HTML部分
echo <<< EOF
<!Doctype HTML>
<html>
    <head>
        <meta charset=utf-8>
        <title>YubiKey認証サンプル</title>
    </head>
    <body>
        <form method='POST'>
        YubiKey OTP：<input type='text' name='otp' size='60' value='{$otp}'>
        <input type='submit' value='送信'>
        </form><br />
        {$mesg}
    </body>
</html>
EOF;
