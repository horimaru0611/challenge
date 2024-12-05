<form id="faceRegistrationForm" method="POST" enctype="multipart/form-data">
    <label for="faceImage">顔写真を撮影してください：</label>
    <input type="file" id="faceImage" name="face_image" accept="image/*" capture="camera" required>
    <button type="submit">顔を登録する</button>
</form>

<?php
    // 顔画像登録処理（PHP）
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['face_image'])) {
    // ユーザーIDを取得（仮にセッションから取得する場合）
    $user_id = $_SESSION['user_id'];
    
    // アップロードされた顔画像を保存
    $image = $_FILES['face_image'];
    $target_dir = "uploads/faces/"; // アップロード先ディレクトリ
    $target_file = $target_dir . basename($image["name"]);
    
    if (move_uploaded_file($image["tmp_name"], $target_file)) {
        // 顔画像のURLをデータベースに保存
        $query = $pdo->prepare("INSERT INTO face_data (user_id, image_url) VALUES (:user_id, :image_url)");
        $query->execute([
            'user_id' => $user_id,
            'image_url' => $target_file
        ]);
        
        echo "顔画像が登録されました！";
    } else {
        echo "画像のアップロードに失敗しました。";
    }
}
?>