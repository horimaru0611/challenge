// PHPで顔認証
<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $imageData = $data['image'];

    // 顔画像を一時ファイルに保存
    $file = 'temp_image.jpg';
    file_put_contents($file, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData)));

    // Pythonで顔認証を行う
    $command = "python3 face_recognition.py " . escapeshellarg($file);
    $output = shell_exec($command);
    $result = json_decode($output, true);

    if ($result['matched']) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}

?>
