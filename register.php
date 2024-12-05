<head>

    <link rel="stylesheet" href="mail.css">
</head>

<?php
function console_log($data){
    echo '<script>';
    echo 'console.log('.json_encode($data).')';
    echo '</script>';
}

// DB接続（PDOを使った例）
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

$password_chk = $_POST['password'];
$confirm_password_chk = $_POST['confirm_password'];

// パスワードと確認用パスワードが一致するかチェック
if ($password_chk !== $confirm_password_chk) {
    echo '<div class="error-message">パスワードと確認用パスワードが一致しません。</div>';
    exit;
}

// パスワードが8文字以上かチェック
if (strlen($password_chk) < 8) {
    echo '<div class="error-message">パスワードは8文字以上で入力してください。</div>';
    exit;
}

// フォームからの入力値を受け取る
$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // パスワードをハッシュ化


$query_1 = $pdo->prepare("SELECT id FROM users WHERE email = :email");
$query_1->execute(['email' => $email]);
$existing_user = $query_1->fetch(PDO::FETCH_ASSOC);

if ($existing_user) {
    echo '<div class="error-message">このメールアドレスは既に登録されています。</div>';
    exit;
}

console_log($username);
console_log($email);
console_log($password);

// メールアドレス認証用のユニークトークンを生成
$token = bin2hex(random_bytes(50));

// ユーザー情報をデータベースに保存
$query = $pdo->prepare("INSERT INTO users (username, email, password, token, is_verified) VALUES (?, ?, ?, ?, 0)");
$query->execute([$username, $email, $password, $token]);

// 認証用のメール送信
$verification_link = "http://localhost/otameshi2/2nd/verify.php?token=" . $token;
$subject = "メールアドレス認証";
$message = "アカウント作成が完了しました。以下のリンクをクリックしてメールアドレスを認証してください。\n\n" . $verification_link;
$headers = "From: horihori0611rh@gmail.com";

mail($email, $subject, $message, $headers);

// ユーザーに認証メールを送信後、メッセージを表示
echo '<div class="success-message">アカウント作成が完了しました。認証メールを送信しましたので、メールアドレスを確認してください。</div>';
?>

