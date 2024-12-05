let selectedGame = null;
let selectedSeat = null;

function fetchSeats(gameId) {
    // XMLHttpRequest または Fetch API で座席情報を非同期で取得
    fetch('get_seats.php?game_id=' + gameId) // ゲームIDを送信
        .then(response => response.json()) // JSON形式でデータを受け取る
        .then(seats => {
            var seatsList = document.getElementById('seats-list');
            seatsList.innerHTML = ''; // 座席リストを空にする

            seats.forEach(function(seat) {
                var li = document.createElement('li');
                li.innerHTML = `<p>${seat.name} - ¥${seat.price.toLocaleString()}</p>
                               <button class="select-seat-btn" data-id="${seat.id}" data-name="${seat.name}" data-price="${seat.price}">選択</button>`;
                seatsList.appendChild(li);
                
            });

            // ボタンがDOMに追加された後にイベントリスナーを設定
            const selectSeatBtns = document.querySelectorAll('.select-seat-btn');
            selectSeatBtns.forEach(button => {
                button.addEventListener('click', function() {
                    const seatId = button.getAttribute('data-id');
                    const seatName = button.getAttribute('data-name');
                    const seatPrice = button.getAttribute('data-price');

                    

                    const ticketCount = document.getElementById('ticket-count-page');
                    const seatPage = document.getElementById('seat-page');

                    selectedSeat = { id: seatId, name: seatName, price: seatPrice };
                    
                    seatPage.style.display = 'none'; // 座席選択ページを非表示にする
                    ticketCount.style.display = 'block'; // チケット枚数選択フォームを表示させる

                    const selectedGameDate = document.getElementById('selected-game-date');
                    const selectedOpponent = document.getElementById('selected-opponent');
                    const selectedSeatName = document.getElementById('selected-seat-name');
                    const selectedSeatPrice = document.getElementById('selected-seat-price');

                    selectedGameDate.textContent = `試合日: ${selectedGame.date}`;
                    selectedOpponent.textContent = `対戦相手: ${selectedGame.opponent}`;
                    selectedSeatName.textContent = `座席名: ${selectedSeat.name}`;
                    selectedSeatPrice.textContent = `価格: ¥${selectedSeat.price}`;
                    
                    // フォームに選択された試合IDと座席IDをセット
                    document.querySelector('input[name="game_id"]').value = selectedGame.id;
                    document.querySelector('input[name="seat_id"]').value = selectedSeat.id;

                    // 座席IDを用いて次の処理を行う
                    console.log('選択された座席ID:', seatId);
                    console.log('選択された試合日:', seatName);
                    console.log('選択された対戦相手:', seatPrice);
                    // 必要に応じて、座席IDを使用してデータベースや次のステップに情報を渡すことができます
                });
            });
        })
        .catch(error => console.error('Error:', error)); // エラーハンドリング
}



document.addEventListener('DOMContentLoaded', function() {
    // ボタンイベント
    const purchaseButton = document.getElementById('purchase-ticket-btn');
    const gamesPage = document.getElementById('ticket-page');
    const seatPage = document.getElementById('seat-page');

    purchaseButton.addEventListener('click', function() {
        document.getElementById('home-page').style.display = 'none';
        gamesPage.style.display = 'block';
    });

    document.querySelectorAll('.select-game-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            var gameId = this.getAttribute('data-id'); // 選択されたゲームのIDを取得
            const gameDate = button.getAttribute('data-date'); // 試合日を取得
        const opponent = button.getAttribute('data-opponent'); // 対戦相手
            console.log('選択された試合ID:', gameId);
            console.log('選択された試合日:', gameDate);
            console.log('選択された対戦相手:', opponent);

            selectedGame = { id: gameId, date: gameDate, opponent: opponent };
            
            // ゲーム選択ページを非表示にし、座席選択ページを表示
            document.getElementById('ticket-page').style.display = 'none';
            document.getElementById('seat-page').style.display = 'block';
    
            // PHPのデータを元に、選択したゲームの座席情報を取得
            fetchSeats(gameId);
        });
    });

});
console.log("処理が実行されました");
