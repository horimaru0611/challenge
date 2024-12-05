<?php
mb_language("Japanese");
mb_internal_encoding("UTF-8");

$to = "horimaru0611@icloud.com"; // 送信先のアドレス
$subject = "テスト送信"; // 件名
$message = "ただいまメールのテスト中です。"; // 本文
$additional_headers = "horihori0611rh@gmail.com"; // ヘッダーオプション

if(mb_send_mail($to, $subject, $message, $additional_headers))
{
	print "メールを送信しました。";
}
else
{
	print "メール送信に失敗しました。";
}