<?php
session_start();

// ログインしていない場合、ログインページにリダイレクト
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// データベース接続設定
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

// ユーザーIDの取得（仮のIDでもOK）
$user_id = $_SESSION['user_id']; // セッションからユーザーIDを取得（適宜変更）

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 購入情報を取得
    $game_id = $_POST['game_id'];
    $seat_id = $_POST['seat_id'];
    $quantity = $_POST['quantity']; // 購入枚数

    // 1. 座席の残り枚数を取得
    $query = $pdo->prepare("SELECT available FROM seats WHERE id = :seat_id");
    $query->execute(['seat_id' => $seat_id]);
    $seat = $query->fetch(PDO::FETCH_ASSOC);

    // 2. 残り枚数が購入枚数以上かチェック
    if ($seat['available'] >= $quantity) {
        // 3. 購入処理（purchasesテーブルに購入履歴を追加）
        $query = $pdo->prepare("
            INSERT INTO purchases (user_id, game_id, seat_id, quantity) 
            VALUES (:user_id, :game_id, :seat_id, :quantity)
        ");// 
        $query->execute([
            'user_id' => $user_id,
            'game_id' => $game_id,
            'seat_id' => $seat_id,
            'quantity' => $quantity
        ]);

        // 4. 残り枚数を減らす
        $query = $pdo->prepare("
            UPDATE seats
            SET available = available - :quantity
            WHERE id = :seat_id
        ");
        $query->execute([
            'quantity' => $quantity,
            'seat_id' => $seat_id
        ]);

        echo "購入が完了しました！";
    } else {
        echo "残り枚数が不足しています。";
    }
}
?>
