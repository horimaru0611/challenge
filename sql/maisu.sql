-- 6. purchasesテーブル: 購入履歴
CREATE TABLE purchases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL, -- 購入したユーザーID（仮にuserテーブルがあると想定）
    game_id INT NOT NULL, -- 試合ID（gamesテーブルの外部キー）
    seat_id INT NOT NULL, -- 座席ID（seatsテーブルの外部キー）
    quantity INT NOT NULL, -- 購入枚数
    purchase_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- 購入日時
    FOREIGN KEY (game_id) REFERENCES games(id),
    FOREIGN KEY (seat_id) REFERENCES seats(id)
);
