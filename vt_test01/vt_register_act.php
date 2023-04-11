<?php
/*---------------------------------------------------------------------------*/
//ログインチェック＆function読み込み
session_start();
include('functions.php');
/*---------------------------------------------------------------------------*/
// データの定義
$username = $_POST['username'];
$password = $_POST['password'];
$pdo = connect_vt_db();
/*---------------------------------------------------------------------------*/
// usernameの重複を確認する。
/*---------------------------------------------------------------------------*/
$sql = 'SELECT * FROM users_table WHERE username=:username';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  $_SESSION['output_message'] =  json_encode(["sql error" => "{$e->getMessage()}"]);
  header("Location:vt_register.php");
  exit();
}

$user = $stmt->fetch(PDO::FETCH_ASSOC);
if ($user) {
  $_SESSION['output_message'] = '既に同じ名前のアカウントが存在します';
  header("Location:vt_register.php");
  exit();
}
/*---------------------------------------------------------------------------*/
//共有データ
//エラーチェック用
$tmp_path = $file['tmp_name'];
$file_err = $file['error'];
$filesize = $file['size'];
/*---------------------------------------------------------------------------*/
//サーバー＆DBアップロード機構
/*---------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------*/
//DBへの保存
/*---------------------------------------------------------------------------*/
// トランザクションを開始する
$pdo->beginTransaction();
/*---------------------------------------------------------------------------*/
//character_main_dataの作成
/*---------------------------------------------------------------------------*/
try {
    //1.item_data
    $stmt1 = $pdo->prepare('INSERT INTO users_table (username, password) VALUES (?, ?)');
    $stmt1->execute([$username, $password]);
    // トランザクションをコミットする
    $pdo->commit();
    $_SESSION['output_message_type'] == 2;//成功メッセージ
    $_SESSION['output_message'] = "'$username'のアカウントを作成しました";
    header("Location:vt_register.php");  
} catch (PDOException $e) {
    // トランザクションをロールバックする
    $pdo->rollback(); 
    $_SESSION['output_message_type'] == 1;//エラーメッセージ
    $_SESSION['output_message'] = json_encode(["db error" => "{$e->getMessage()}"]);
    exit();
}

//header("Location:vt_login.php");
?>
<button onclick="location.href='vt_login.php'">新規登録画面へ</button>