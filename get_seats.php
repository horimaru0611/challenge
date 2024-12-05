<?php
// データベース接続設定（必要に応じて変更）
$host = 'localhost';
$dbname = 'ticket_db';
$username = 'root';
$password = '';

// DB接続
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// GETパラメータからgame_idを取得
$gameId = isset($_GET['game_id']) ? (int)$_GET['game_id'] : 0;

if ($gameId > 0) {
    // game_idに基づいてseatsテーブルから座席情報を取得
    $stmt = $pdo->prepare("SELECT id, name, price, available FROM seats WHERE game_id = :game_id");
    $stmt->bindParam(':game_id', $gameId, PDO::PARAM_INT);
    $stmt->execute();

    // 座席情報を配列として取得
    $seats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // JSON形式で返す
    echo json_encode($seats);
} else {
    echo json_encode([]);
}
?>
