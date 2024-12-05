SELECT 
    games.id AS game_id,
    games.date,
    games.opponent,
    games.stadium,
    seats.id AS seat_id,
    seats.name AS seat_name,
    seats.price AS seat_price,
    seats.available AS seat_available
FROM 
    games
JOIN 
    seats ON games.id = seats.game_id;
