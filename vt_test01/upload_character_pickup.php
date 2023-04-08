<?php include('login_set.php'); 
/*セッション開始、ログインチェック、function読み込み、DBチェック、セッション定義*/ ?>
<?php
/*---------------------------------------------------------------------------*/
$_SESSION['pickup_character'] == $_POST["pickup_character_id"];
if($_POST['character_choice'] == 0){
  unset($_SESSION['play_character']);
  // 処理後にページを移動
  $_SESSION['output_message_type'] == 0;//成功メッセージ
  $_SESSION['output_message'] = 'キャラクター登録を解除しました';
  header("location: list_character_pickup.php");
}else{
/*---------------------------------------------------------------------------*/
//セッションデータの更新
$_SESSION['play_character'] = $_POST["pickup_character_id"];

//キャラクター名の検索
$search_term = $_POST["pickup_character_id"];
$sql = "SELECT * FROM character_game_data WHERE character_id = '$search_term'";
$stmt = $pdo->prepare($sql);
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
// SQL作成&実行
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
$my_character = $result[0]["character_name"];

$_SESSION['output_message_type'] == 0;//成功メッセージ
$_SESSION['output_message'] = "$my_character"."をマイキャラクターに設定しました。";

// 処理後にページを移動
header("location: list_character.php");

/*---------------------------------------------------------------------------*/
?>
<a href="./list_character_pickup.php">戻る</a>
