<head>
    <link rel="stylesheet" href="form.css">
</head>

<div class="container">
    <header>
        <h1>カオチケ</h1>
    </header>
    
    <form method="POST" action="register.php">
        <h2>新規アカウント作成</h2>
        
        <!-- ユーザー名 -->
        <label for="username">ユーザー名</label>
        <input type="text" id="username" name="username" required>
        
        <!-- メールアドレス -->
        <label for="email">メールアドレス</label>
        <input type="email" id="email" name="email" required>
        
        <!-- パスワード -->
        <label for="password">パスワード (8文字以上)</label>
        <input type="password" id="password" name="password" required minlength="8">
        
        <!-- 確認用パスワード -->
        <label for="confirm_password">パスワード確認</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        
        <input type="submit" value="アカウント作成">
        
        <!-- ログインフォームへのリンク -->
        <div class="form-link">
            <p>すでにアカウントをお持ちですか？ <a href="login_form.php">ログイン</a></p>
        </div>
    </form>
</div>
