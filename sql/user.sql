ALTER TABLE users ADD(
    email VARCHAR(255) NOT NULL UNIQUE,        -- メールアドレス（ユニーク制約）
    password VARCHAR(255) NOT NULL,            -- パスワード（ハッシュ化されたパスワード）
    token VARCHAR(255) NOT NULL,               -- メール認証用のトークン
    is_verified TINYINT(1) DEFAULT 0,          -- メール認証状態（0: 未認証, 1: 認証済み）
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- アカウント作成日時
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  -- 最終更新日時
);
