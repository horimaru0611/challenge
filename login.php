<head>

    <link rel="stylesheet" href="mail.css">
</head>

<?php
// login.php
session_start();
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

// フォームからの入力値を受け取る
$email = $_POST['email'];
$password = $_POST['password'];

// メールアドレスに一致するユーザーを取得
$query = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$query->execute([$email]);
$user = $query->fetch(PDO::FETCH_ASSOC);

// ユーザーが存在し、パスワードが正しい場合
if ($user && password_verify($password, $user['password'])) {
    // メール認証されていない場合
    if ($user['is_verified'] == 0) {
        echo '<div class="error-message">メールアドレスが認証されていません。認証メールを確認してください。</div>';
    } else {
        
        // セッションを開始して、ログイン状態を保持する処理を追加する
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];

        header('Location: index.php');
    }
} else {
    echo '<div class="error-message">無効なメールアドレスまたはパスワードです。</div>';
}
?>
