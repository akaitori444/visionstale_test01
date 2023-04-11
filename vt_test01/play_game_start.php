<?php include('login_set.php'); 
/*セッション開始、ログインチェック、function読み込み、DBチェック、セッション定義*/ ?>
<?php
/*---------------------------------------------------------------------------*/
//POSTデータ取得
$play_character = $_POST['character_id'];
$play_scenario =$_POST['scenario_id'];
/*---------------------------------------------------------------------------*/
//0.キャラクターデータ取得
/*---------------------------------------------------------------------------*/
$sql = "SELECT * FROM character_game_data LEFT OUTER JOIN character_spec_set ON character_id = character_spec_id WHERE character_id = '$play_character'";
$stmt = $pdo->prepare($sql);
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
// SQL作成&実行
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
/*---------------------------------------------------------------------------*/
/*//確認用
echo('<pre>');
echo var_dump($result);
exit();
/*---------------------------------------------------------------------------*///キャラクターステータス定義
foreach ($result as $record){
  //名前、説明、画像
  $pl_name = $record['character_name'];
  $pl_introduction = $record['character_introduction'];
  $pl_images = $record['save_path'];
  //スペック
  $pl_attack = $record['attack'];
  $pl_toughness = $record['toughness'];
  $pl_speed = $record['speed'];
  $pl_technic = $record['technic'];
  $pl_imagination = $record['imagination'];
  $pl_chase = $record['chase'];
  //接続率  
  $spec = [$pl_attack, $pl_toughness, $pl_speed, $pl_technic, $pl_imagination, $pl_chase];
  $total = 0;
  foreach ($spec as $record):
    if($record > 3){
      $count = $record * 2 - 3;
    }else{
      $count = $record;
    }
    $total += $count;
  endforeach;
  $pl_Access_power = 100 - $total;
  //ステータス
  $pl_hp = $pl_toughness * 2 + 6 ;
  $pl_critical = $pl_technic * 3 ;
  $pl_round = ($pl_speed + $pl_technic) * 5 + $pl_speed;
  $pl_battle = ($pl_attack + $pl_toughness + $pl_technic) * 6;
  if($pl_Access_power < $pl_battle){
    $pl_battle = $pl_Access_power;
  }
  $pl_search = ($pl_technic + $pl_imagination + $pl_chase) * 6;
  if($pl_Access_power < $pl_search){
    $pl_search = $pl_Access_power;
  }
}
$_SESSION['play_character_date'] = [
  "character_name" => $pl_name,
  "character_introduction" => $pl_introduction,
  "character_image" => $pl_images,
  "attack" => $pl_attack,
  "toughness" => $pl_toughness,
  "speed" => $pl_speed,
  "technic" => $pl_technic,
  "imagination" => $pl_imagination,
  "chase" => $pl_chase,
  "Access_power" => $pl_Access_power,
  "hp" => $pl_hp,
  "critical" => $pl_critical,
  "round" => $pl_round,
  "character_battle" => $pl_battle,
  "character_search" => $pl_search
];
/*---------------------------------------------------------------------------*/
//1.シナリオデータ取得
/*---------------------------------------------------------------------------*/
$sql1 = "SELECT * FROM scenario_data LEFT OUTER JOIN scene_set ON scenario_id = scenario_connect LEFT OUTER JOIN scene ON scene_connect = scene_id WHERE scenario_id = '$play_scenario' ORDER BY order_number ASC";
$stmt1 = $pdo->prepare($sql1);
try {
  $status1 = $stmt1->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
// SQL作成&実行
$result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
/*---------------------------------------------------------------------------*/
//シーン数
$end_page = count($result1);
/*---------------------------------------------------------------------------*/
//名前、説明、画像
$scenario_name = $result1[0]["scenario_name"];
$scenario_introduction = $result1[0]["scenario_introduction"];
$scenario_image = $result1[0]["save_path"];
/*---------------------------------------------------------------------------*/
$n = 0;
foreach ($result1 as $record):
  $scene_name[$n] = $record["scene_name"];
  $scene_image[$n] = $record["scene_image"];
  $scene_introduction[$n] = $record["scene_introduction"];
  $scene_event_type[$n] = $record["scene_event_type"];
  $effect_set_connect[$n] = $record["effect_set_connect"];
  $actor_set_connect[$n] = $record["actor_set_connect"];
  $n++;
  if($n>$end_page){
    break;
  }  
endforeach;

$_SESSION['play_scenario_date'] = [
  "scenario_name" => $scenario_name,
  "scenario_introduction" => $scenario_introduction,
  "scenario_image" => $scenario_image,
  "scene_name" => $scene_name,
  "scene_image" => $scene_image,
  "scene_introduction" => $scene_introduction,
  "scene_event_type" => $scene_event_type,
  "effect_set_connect" => $effect_set_connect,
  "actor_set_connect" => $actor_set_connect,
  "end_page" => $end_page,
];
/*---------------------------------------------------------------------------*/
/*
echo('<pre>');
echo var_dump($result2);
echo var_dump($_SESSION);
echo('<pre>');
exit();
/*---------------------------------------------------------------------------*/
header("location: play_game.php");


?>