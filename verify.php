<head>

    <link rel="stylesheet" href="mail.css">
</head>

<?php
// verify.php
function console_log($data){
    echo '<script>';
    echo 'console.log('.json_encode($data).')';
    echo '</script>';
  }

// トークンをURLから取得
$token = $_GET['token'];

console_log($token);

// DB接続
$host = 'localhost'; // データベースのホスト名
$dbname = 'ticket_db'; // 使用するデータベース名
$username = 'root'; // データベースのユーザー名
$password = ''; // ユーザーのパスワード

try {
    // PDOオブジェクトを生成してデータベースに接続
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // エラーモードを例外に設定
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // 接続失敗時にエラーメッセージを表示
    echo "接続エラー: " . $e->getMessage();
    exit;
}

// トークンが一致するユーザーを検索
$query = $pdo->prepare("SELECT * FROM users WHERE token = ?");
$query->execute([$token]);
$user = $query->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // ユーザーが存在すれば、アカウントを有効化
    $query = $pdo->prepare("UPDATE users SET is_verified = 1 WHERE token = ?");
    $query->execute([$token]);

    echo '<div class="success-message">メールアドレスが認証されました。ログインしてください。</div>';
} else {
    echo '<div class="error-message">無効なリンクです。</div>';
}
?>
