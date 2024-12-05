<?php
session_start();


// DB接続設定（例）
$host = 'localhost';
$dbname = 'ticket_db';
$username = 'root';
$password = '';
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

// データ取得（試合日程）
$query = $pdo->query("SELECT * FROM games");
$games = $query->fetchAll(PDO::FETCH_ASSOC);

// 座席情報
//$seatQuery = $pdo->query("SELECT * FROM seats");
//$seats = $seatQuery->fetchAll(PDO::FETCH_ASSOC);


// ログインしていない場合、ログインページへリダイレクト
if (!isset($_SESSION['user_id'])) {
    header('Location: login_form.php');
    exit;
}

// ログインしていない場合、ログインページへリダイレクト
echo 'ようこそ、' . $_SESSION['username'] . 'さん！';


?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カオチケ</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<script src="app.js"></script>

<div class="container">
    <header>
        <h1>カオチケ</h1>
     
    <nav>
    <button type="submit" onclick="location.href='logout.php'">ログアウト</button>
    <!--<form method="POST" action="logout.php">
    <button type="submit">ログアウト</button>
</form>
            <button id="login-btn" onclick="location.href='login_form.php'">ログイン</button>
            <button id="create-account-btn" onclick="location.href='account.php'">アカウント作成</button>-->
        </nav>
    </header>

    <main id="main-content">
        <div id="home-page">
            <button id="purchase-ticket-btn">チケットを購入する</button>
        </div>

        <div id="ticket-page" style="display:none;">
    <h2>試合日程選択</h2>
    <ul id="games-list">
        <?php foreach ($games as $game): ?>
            <li>
                <p><?php echo date('Y-m-d', strtotime($game['date'])); ?> - <?php echo $game['opponent']; ?></p>
                <button class="select-game-btn" data-id="<?php echo $game['id']; ?>" data-date="<?php echo $game['date']; ?>" data-opponent="<?php echo $game['opponent']; ?>">選択</button>
            </li>
        <?php endforeach; ?>
    </ul>
</div>




<div id="seat-page" style="display:none;">
    <h2>座席選択</h2>
    <ul id="seats-list"></ul> <!-- 空のリストを作成 -->
            </ul>
        </div>

        <div id="ticket-count-page" style="display:none;">
    <div class="ticket-form-container">
        <form method="POST" action="purchase.php">
            <input type="hidden" name="game_id" value="<?= $game_id ?>"> <!-- 試合ID -->
            <input type="hidden" name="seat_id" value="<?= $seat_id ?>"> <!-- 座席ID -->

            <h2>チケット購入</h2>
            
            <!-- 選択された試合日と座席情報を表示 -->
            <div class="ticket-info">
                <p><strong>試合日:</strong> <span id="selected-game-date"></span></p>
                <p><strong>対戦相手:</strong> <span id="selected-opponent"></span></p>
                <p><strong>座席名:</strong> <span id="selected-seat-name"></span></p>
                <p><strong>価格:</strong> <span id="selected-seat-price"></span></p>
            </div>

            <!-- 購入枚数 -->
            <div class="ticket-quantity">
                <label for="quantity">購入枚数:</label>
                <input type="number" name="quantity" id="quantity" min="1" max="<?= $seat['available'] ?>" required>
            </div>

            <!-- 購入ボタン -->
            <div class="submit-btn-container">
                <button type="submit">購入する</button>
            </div>
        </form>
    </div>
</div>

    </main>
</div>




</body>
</html>
