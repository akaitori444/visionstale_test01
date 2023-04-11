<?php
session_start();
include('functions.php');

$username = $_POST['username'];
$password = $_POST['password'];

$pdo = connect_vt_db();

// username，password，deleted_atの3項目全ての条件満たすデータを抽出する．
$sql = 'SELECT * FROM users_table WHERE username=:username AND password=:password AND deleted_at IS NULL';

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) {
  $_SESSION['output_message_type'] == 1;//エラーメッセージ
  $_SESSION['output_message'] = 'ログイン情報に誤りがあります';
  header("Location:vt_login.php");
  exit();
} else {
  $_SESSION['output_message_type'] == 2;//成功メッセージ
  $_SESSION['output_message'] = 'ようこそVisionsTaleの世界へ';
  $_SESSION = array();
  $_SESSION['session_id'] = session_id();
  $_SESSION['id'] =  $user['id'];
  $_SESSION['is_admin'] = $user['is_admin'];
  $_SESSION['username'] = $user['username'];
  $_SESSION["user_only"] = 1;
  header("Location:index.php");
  exit();
}