
<head>
    <link rel="stylesheet" href="form.css">
</head>
<div class="container">
    <header>
        <h1>カオチケ</h1>
    </header>
    
    <form method="POST" action="login.php">
        <h2>ログイン</h2>
        
        <!-- メールアドレス -->
        <label for="email">メールアドレス</label>
        <input type="email" id="email" name="email" required>
        
        <!-- パスワード -->
        <label for="password">パスワード</label>
        <input type="password" id="password" name="password" required>
        
        <input type="submit" value="ログイン">
        
        <!-- アカウント作成フォームへのリンク -->
        <div class="form-link">
            <p>アカウントをお持ちでないですか？ <a href="account.php">新規作成</a></p>
        </div>
    </form>
</div>
