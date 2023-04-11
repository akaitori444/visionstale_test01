<?php
/*---------------------------------------------------------------------------*/
//ログインチェック＆function読み込み
session_start();
include('functions.php');
check_session_id();
$pdo = connect_vt_db();
/*-------------------------------------------------------------------------------*/
//セッション定義
//user
if(isset($_SESSION['is_admin'])){$user_admin = $_SESSION['is_admin'];}
if(isset($_SESSION['username'])){$user_name = $_SESSION['username'];}
if(isset($_SESSION['id'])){$user_id = $_SESSION['id'];}
//pickup
if(isset($_SESSION["pickup_character_id"])){$pickup_character = $_SESSION["pickup_character_id"];}
if(isset($_SESSION["pickup_scenario_id"])){$pickup_scenario = $_SESSION["pickup_scenario_id"];}
//order,search_term
if(isset($_SESSION["order"])){$order = $_SESSION["order"];}
if(isset($_SESSION["search_term"])){$search_term= $_SESSION["search_term"];}
//play
if(isset($_SESSION['play_character'])){$play_character= $_SESSION['play_character'];}
if(isset($_SESSION['play_character_date'])){$play_character_date = $_SESSION['play_character_date'];}
if(isset($_SESSION['play_scenario_date'])){$play_scenario_date = $_SESSION['play_scenario_date'];}
/*---------------------------------------------------------------------------*/
if(isset($_POST["user_only_command"])){
  if($_POST["user_only_command"] == 1){
      $user_only_set = "自作データのみ表示";
      $user_only_set_button = "すべて表示";
      $_SESSION["user_only"] = 1;
      $user_only_command = 0;
  }elseif($_POST["user_only_command"] == 0){
      $user_only_set = "すべて表示";
      $user_only_set_button = "自作データのみ表示";
      $_SESSION["user_only"] = 0;
      $user_only_command = 1;
  }
  }else{
    if($_SESSION["user_only"] == 1){
        $user_only_set = "自作データのみ表示";
        $user_only_set_button = "すべて表示";
        $_SESSION["user_only"] = 1;
        $user_only_command = 0;
    }elseif($_SESSION["user_only"] == 0){
        $user_only_set = "すべて表示";
        $user_only_set_button = "自作データのみ表示";
        $_SESSION["user_only"] = 0;
        $user_only_command = 1;
  }
  }
/*-------------------------------------------------------------------------------*/
// メッセージを作成
/*-------------------------------------------------------------------------------*/
$random_message = Randommessage();
if(isset($_SESSION['output_message'])){
  if($_SESSION['output_message_type'] == 1){//エラーメッセージ
    $sessoin_message_title = 'ERROR';
    $navigator_condition = 1;
  }elseif($_SESSION['output_message_type'] == 2){//成功メッセージ
    $sessoin_message_title = 'GOOD';
    $navigator_condition = 2;
  }else{
    $sessoin_message_title = 'message'; 
    $navigator_condition = 0;
    $sessoin_message = $_SESSION['output_message'];
  }
}else{//通常ランダムメッセージ
  $sessoin_message_title = 'message'; 
  $navigator_condition = 0;
  $sessoin_message = '';}
unset($_SESSION['output_message_type']);
unset($_SESSION['output_message']);  
/*-------------------------------------------------------------------------------*/
if($navigator_condition == 0){
  $navigator = 'asset\robot\robot_a.png';
}elseif($navigator_condition == 1){
  $navigator = 'asset\robot\robot_h.png';
}elseif($navigator_condition == 2){
  $navigator = 'asset\robot\robot_b.png';
}
/*---------------------------------------------------------------------------*/
//マイキャラクターの呼び出し
/*---------------------------------------------------------------------------*/
$pdo = connect_vt_db();
//character_game_data検索
if(isset($_SESSION['play_character'])){
  $play_character = $_SESSION['play_character'];
  $my_sql = "SELECT * FROM character_game_data LEFT OUTER JOIN character_spec_set ON character_spec_id = character_id WHERE character_id = '$play_character'";
  $my_stmt = $pdo->prepare($my_sql);
  try {
    $status = $my_stmt->execute();
  } catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
  }
  // SQL作成&実行
  $my_result = $my_stmt->fetchAll(PDO::FETCH_ASSOC);
}
/*---------------------------------------------------------------------------*/
//play_characterの取得
if(@$_SESSION['play_character'] != ""){
  $pdo = connect_vt_db();
  $search_play_character = $_SESSION['play_character'];
  $sql = "SELECT * FROM character_game_data WHERE save_path = '$search_play_character'";
  $stmt = $pdo->prepare($sql);
  try {
    $status = $stmt->execute();
  } catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
  }
// SQL作成&実行
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}else{
  $search_play_character= "";
}
/*---------------------------------------------------------------------------*/
//キャラクター数の取得
$sql1 = 'SELECT COUNT(*) FROM character_main_data';
$stmt1 = $pdo->prepare($sql1);
try {
  $status1 = $stmt1->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
// SQL作成&実行
$result_character_data_COUNT = $stmt1->fetchAll(PDO::FETCH_ASSOC);
/*---------------------------------------------------------------------------*/
//アイテム数の取得
$sql2 = 'SELECT COUNT(*) FROM item_data';
$stmt2 = $pdo->prepare($sql2);
try {
  $status2 = $stmt2->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
// SQL作成&実行
$result_item_data_COUNT = $stmt2->fetchAll(PDO::FETCH_ASSOC);
/*---------------------------------------------------------------------------*/
//シナリオ数の取得
$sql3 = 'SELECT COUNT(*) FROM scenario_data';
$stmt3 = $pdo->prepare($sql3);
try {
  $status3 = $stmt3->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
// SQL作成&実行
$result_scenario_data_COUNT = $stmt3->fetchAll(PDO::FETCH_ASSOC);
/*---------------------------------------------------------------------------*/
?>