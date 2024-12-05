<?php
session_start();

// セッションの変数を全て解除
session_unset();

// セッションを破棄
session_destroy();

// ログインページにリダイレクト
header('Location: login_form.php');
exit;
