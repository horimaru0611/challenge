<?php
$query = $pdo->prepare("
SELECT s.id, s.name, s.price, s.available
FROM seats s
JOIN games_seats gs ON s.id = gs.seat_id
WHERE gs.game_id = :game_id
");
$query->execute(['game_id' => $game_id]);
$seats = $query->fetchAll(PDO::FETCH_ASSOC);