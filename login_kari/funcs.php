<?php
//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

//DB接続
function db_conn(){
  try {
    $host = 'localhost'; // データベースのホスト名
    $dbname = 'ticket_db'; // 使用するデータベース名
    $username = 'root'; // データベースのユーザー名
    $password = ''; // ユーザーのパスワード
    return new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  } catch (PDOException $e) {
    exit('DB Connection Error:'.$e->getMessage());
  }
}

//SQLエラー
function sql_error($stmt){
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}

//リダイレクト
function redirect($file_name){
    header("Location: ".$file_name);
    exit();
}

//SessionCheck
function sschk(){
  if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!=session_id()){
    exit("Login Error");
  }else{
    session_regenerate_id(true);
    $_SESSION["chk_ssid"] = session_id();
  }
}

//fileUpload("送信名","アップロード先フォルダ");
function fileUpload($fname,$path){
    if (isset($_FILES[$fname] ) && $_FILES[$fname]["error"] ==0 ) {
        //ファイル名取得
        $file_name = $_FILES[$fname]["name"];
        //一時保存場所取得
        $tmp_path  = $_FILES[$fname]["tmp_name"];
        //拡張子取得
        $extension = pathinfo($file_name, PATHINFO_EXTENSION);
        //ユニークファイル名作成
        $file_name = date("YmdHis").md5(session_id()) . "." . $extension;
        // FileUpload [--Start--]
        $file_dir_path = $path.$file_name;
        if ( is_uploaded_file( $tmp_path ) ) {
            if ( move_uploaded_file( $tmp_path, $file_dir_path ) ) {
                chmod( $file_dir_path, 0644 );
                return $file_name; //成功時：ファイル名を返す
            } else {
                return 1; //失敗時：ファイル移動に失敗
            }
        }
     }else{
         return 2; //失敗時：ファイル取得エラー
     }
}
