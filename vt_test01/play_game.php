<?php include('login_set.php'); 
/*セッション開始、ログインチェック、function読み込み、DBチェック、セッション定義*/ ?>
<?php
/*---------------------------------------------------------------------------*/
/*//確認用
echo('<pre>');
echo var_dump($_SESSION);
echo var_dump($_POST);
echo('<pre>');
exit();
/*---------------------------------------------------------------------------*/
//0.キャラクターデータ取得
/*---------------------------------------------------------------------------*/
//play_character_date解凍
$play_character_date = $_SESSION['play_character_date'];
  //名前、説明、画像
  $pl_name = $play_character_date["character_name"];
  //$pl_introduction = $play_character_date['character_introduction'];
  $pl_images = $play_character_date['character_image'];
  //スペック
  $pl_attack = $play_character_date['attack'];
  $pl_toughness = $play_character_date['toughness'];
  $pl_speed = $play_character_date['speed'];
  $pl_technic = $play_character_date['technic'];
  $pl_imagination = $play_character_date['imagination'];
  $pl_chase = $play_character_date['chase'];
  //接続率  
  $pl_Access_power = $play_character_date['Access_power'];
  //ステータス
  $pl_hp = $play_character_date['hp'];
  $pl_critical = $play_character_date['critical'];
  $pl_round = $play_character_date['round'];
  $pl_battle = $play_character_date['character_battle'];
  $pl_search = $play_character_date['character_search'];
/*---------------------------------------------------------------------------*/
//1.シナリオデータ取得
/*---------------------------------------------------------------------------*/
//play_character_date解凍
$play_scenario_date = $_SESSION['play_scenario_date'];
  //名前、説明、画像
  $scenario_name = $play_scenario_date['scenario_name'];
  $scenario_introduction = $play_scenario_date['scenario_introduction'];
  $scenario_image = $play_scenario_date['scenario_image'];
  //ページ数
  $end_page = $play_scenario_date['end_page'];

/*---------------------------------------------------------------------------*/
//進行度
//unset($_SESSION['play_scenario_date']);

if($_POST){ 
  $battle_command = $_POST["battle_command"];
  //ページ進行度(battle_command9で次ページへ移動)
  if($battle_command == 9){ 
    $battle_command = 0;
    $now_page = $_POST["now_page"] + 1;
  }else{
    $now_page = $_POST["now_page"];  
  }
}else{
  $battle_command = 0;
  $now_page = 0;//ページ進行度
}

if($now_page >= $end_page){
  header('Location:play_game_end.php');
} 
/*---------------------------------------------------------------------------*/
//進行度に応じたシーン取得
/*---------------------------------------------------------------------------*/
$scene_name = $play_scenario_date["scene_name"];
$scene_name_now = $scene_name[$now_page];
$scene_image = $play_scenario_date["scene_image"];
$scene_image_now = $scene_image[$now_page];
$scene_introduction = $play_scenario_date["scene_introduction"];
$scene_introduction_now = $scene_introduction[$now_page];
$scene_event_type = $play_scenario_date["scene_event_type"];
$scene_event_type_now = $scene_event_type[$now_page];
/*---------------------------------------------------------------------------*/
$actor_set_connect = $play_scenario_date["actor_set_connect"];
$actor_set_connect_now = $actor_set_connect[$now_page];
/*---------------------------------------------------------------------------*/
//2.NPCキャラクターデータ取得
/*---------------------------------------------------------------------------*/
$sql2 = "SELECT * FROM character_game_data LEFT OUTER JOIN character_spec_set ON character_id = character_spec_id WHERE character_id = '$actor_set_connect_now'";
$stmt2 = $pdo->prepare($sql2);
try {
  $status2 = $stmt2->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
// SQL作成&実行
$result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
/*---------------------------------------------------------------------------*/
//NPCステータス定義
foreach ($result2 as $record){
  //名前
  $npc_name = $record['character_name'];
  //$npc_introduction = $record['character_introduction'];
  $npc_image = $record['save_path'];
  //スペック
  $npc_attack = $record['attack'];
  $npc_toughness = $record['toughness'];
  $npc_speed = $record['speed'];
  $npc_technic = $record['technic'];
  $npc_imagination = $record['imagination'];
  $npc_chase = $record['chase'];
  //接続率  
  $spec = [$npc_attack, $npc_toughness, $npc_speed, $npc_technic, $npc_imagination, $npc_chase];
  $total = 0;
  foreach ($spec as $record):
    if($record > 3){
      $count = $record * 2 - 3;
    }else{
      $count = $record;
    }
    $total += $count;
  endforeach;
  $npc_Access_power = 100 - $total;
  //ステータス
  $npc_hp = $npc_toughness * 2 + 6 ;
  $npc_critical = $npc_technic * 3 ;
  $npc_round = ($npc_speed + $npc_technic) * 5 + $npc_speed;
  $npc_battle = ($npc_attack + $npc_toughness + $npc_technic) * 6;
  if($npc_Access_power < $npc_battle){
    $npc_battle = $npc_Access_power;
  }
  $npc_search = ($npc_technic + $npc_imagination + $npc_chase) * 6;
  if($npc_Access_power < $npc_search){
    $npc_search = $npc_Access_power;
  }    
}
$_SESSION['npc_character_date'] = [
  'npc_name' => $npc_name,
  //'npc_introduction' => $npc_introduction,
  'npc_image' => $npc_image,
  'attack' => $npc_attack,
  'toughness' => $npc_toughness,
  'speed' => $npc_speed,
  'technic' => $npc_technic,
  'imagination' => $npc_imagination,
  'chase' => $npc_chase,
  'Access_power' => $npc_Access_power,
  'hp' => $npc_hp,
  'critical' => $npc_critical,
  'round' => $npc_round,
  'npc_battle' => $npc_battle,
  'npc_search' => $npc_search
];
/*---------------------------------------------------------------------------*/
//システム定義
/*---------------------------------------------------------------------------*/
//メッセージ定義
$msg = ' ';
$msg1 = ' ';
$msg2 = ' ';
/*---------------------------------------------------------------------------*/
//ダメージ計算
$damage = rand(1,$pl_attack);
//echo 'PL通常攻撃威力は', ' ', $damage, '<br />';
$damage1 = rand(1,$pl_attack) + rand(1,6);
//echo 'PL通常クリティカル攻撃威力は', ' ', $damage1, '<br />';
$damage2 = rand(1,$pl_attack)*2;
//echo 'PLスキル攻撃威力は', ' ', $damage2, '<br />';
$damage3 = rand(1,$pl_attack)*2 + rand(1,6);
//echo 'PLスキルクリティカル攻撃威力は', ' ', $damage3, '<br />';
$npc_damage1 = rand(1,$npc_attack);
//echo '敵ダメージ量は', ' ', $npc_damage1, '<br />';
$npc_damage2 = rand(1,$npc_attack) + rand(1,6);
//echo '敵ダメージ量は', ' ', $npc_damage1, '<br />';
/*---------------------------------------------------------------------------*/
//ダイス判定
$dice_1 = rand(1,100);
//echo 'ダイス目は', ' ', $dice_1, '<br />';
$dice_2 = rand(1,100);
//echo 'ダイス目は', ' ', $dice_2, '<br />';
//echo '行動判定は', ' ', $_POST["battle_command"], '<br />';
//PLダイス判定
if($dice_1 <= $pl_critical){
  $attack_result_1 = 2;
  //echo '判定クリティカル成功', '<br />';
}elseif($dice_1 <= $pl_Access_power){
  $attack_result_1 = 1;
  //echo '判定成功', '<br />';
}else{
  $attack_result_1 = 0;
  //echo '判定失敗', '<br />';
}
//調査ダイス判定
if($dice_1 <= $pl_critical){
  $search_result = 2;
  //echo '判定クリティカル成功', '<br />';
}elseif($dice_1 <= $pl_search){
  $search_result = 1;
  //echo '判定成功', '<br />';
}else{
  $search_result = 0;
  //echo '判定失敗', '<br />';
}
//NPCダイス判定
if($dice_2 <= $pl_critical){
  $attack_result_2 = 2;
  //echo '判定クリティカル成功', '<br />';
}elseif($dice_2 <= $npc_Access_power){
  $attack_result_2 = 1;
  //echo '判定成功', '<br />';
}else{
  $attack_result_2 = 0;
  //echo '判定失敗', '<br />';
}
/*---------------------------------------------------------------------------*/
//バトルコマンド進行
/*---------------------------------------------------------------------------*/
//PLの攻撃判定＆敵のHP
if($battle_command == 0){ //戦闘前
  $npc_hp_set = $npc_hp;
  $npc_Access = $npc_Access_power;
  $msg = "$scene_introduction_now";
  $msg1 = '';
  $msg2 = '';
}elseif($battle_command == 1){ //戦闘前
  $npc_hp_set = $npc_hp;
  $npc_Access = $npc_Access_power;
  $msg = '';
  $msg1 = 'バトル開始だ！';
  $msg2 = '行動選択して戦おう';
}elseif($battle_command == 2){ //近接攻撃
  if($attack_result_1 == 1){
    $npc_hp_set = $_POST["npc_hp"] - $damage;
    $msg = "$scene_introduction_now";
    $msg1 = "近接攻撃！ $damage のダメージ！";
  }elseif($attack_result_1 == 2){
    $npc_hp_set = $_POST["npc_hp"] - $damage1;
    $msg = "$scene_introduction_now";
    $msg1 = "近接クリティカル攻撃！ $damage1 の大ダメージ！";
  }elseif($attack_result_1 == 0){
    $npc_hp_set = $_POST["npc_hp"];
    $msg = "$scene_introduction_now";
    $msg1 = "攻撃失敗…";
  }
  $npc_Access = $_POST["npc_Access"];
}elseif($battle_command == 3){ //スキルによる攻撃
  if($attack_result_1 == 1){
    $npc_hp_set = $_POST["npc_hp"] - $damage2;
    $npc_Access_power = $_POST["npc_Access"] - 10;
    $msg = "$scene_introduction_now";
    $msg1 = "スキル攻撃！ $damage2 のダメージ！";
  }elseif($attack_result_1 == 2){
    $npc_hp_set = $_POST["npc_hp"] - $damage3;
    $npc_Access_power = $_POST["npc_Access"] - 10;
    $msg = "$scene_introduction_now";
    $msg1 = "スキルクリティカル攻撃！ $damage3 の大ダメージ！";
  }elseif($attack_result_1 == 0){
    $npc_hp_set = $_POST["npc_hp"];
    $msg = "$scene_introduction_now";
    $msg1 = "攻撃失敗…";
  }
  $npc_Access = $_POST["npc_Access"];
}elseif($battle_command == 4){ //調査
  if($search_result == 1){
    $npc_Access = $_POST["npc_Access"] - 2*$damage2;
    $msg = "調査！ 解析が進んだ";
  }elseif($search_result == 2){
    $npc_Access = $_POST["npc_Access"] - 5*$damage3;
    $msg = "調査クリティカル！ とても解析が進んだ";
  }elseif($search_result == 0){
    $npc_Access = $_POST["npc_Access"];
    $msg = "調査失敗…";
  }
  $npc_hp_set = $_POST["npc_hp"];
  $pl_hp = $_POST["pl_hp"] - $npc_damage1;
  $msg1 = "敵からの反撃！ $npc_damage1 のダメージ！";
} elseif ($battle_command == 5) { //待機
  $npc_hp_set = $_POST["npc_hp"];
  $npc_Access = $_POST["npc_Access"];
  $msg = "なにもせずに様子を伺う";
}elseif ($battle_command == 6) { //回復アイテムを使う
  $npc_hp_set = $_POST["npc_hp"];
  $npc_Access = $_POST["npc_Access"];
  $msg = "回復薬を使った";
}
/*-------------------------------------------------------------------------*/
//敵の攻撃判定＆PLのHP
/*-------------------------------------------------------------------------*/
if ($battle_command == 0) { //戦闘前
  $pl_hp_set = $pl_hp;
  $pl_Access = $pl_Access_power;  
} elseif ($battle_command == 5) {//回復アイテムを使う
  $pl_hp_set = $pl_hp;
  $heel_item--;
  $msg1 = "体力が最大まで回復した";
}
else{
  if($attack_result_2 == 1){
    $pl_hp_set = $_POST["pl_hp"] - $npc_damage1;
    $msg1 = "敵からの反撃！ $npc_damage1 のダメージ！";
    }elseif($attack_result_2 == 2){
    $pl_hp_set = $_POST["pl_hp"] - $npc_damage2;
    $msg1 = "敵からのクリティカル反撃！ $npc_damage2 の大ダメージ！";
  }elseif($attack_result_2 == 0){
    $pl_hp_set = $_POST["pl_hp"];
    $msg1 = "敵からの攻撃をかわした！！";
  }
  $pl_Access = $pl_Access_power;  

}
/*-------------------------------------------------------------------------*/
//ゲームの分岐判定
/*-------------------------------------------------------------------------*/
//PLのHP管理
if($pl_hp_set > 0){
  $pl_images_set = $pl_images;
}elseif($pl_hp_set <= 0){
  $msg = 'HPがなくなった。';
  $msg1 = '戦闘終了だ。';
  $pl_images_set = 'asset/icon/loose.png';
}
//NPCのHP管理
if($npc_hp_set > 0 & $npc_Access > 0){
  $npc_images = $npc_image;
}elseif($npc_hp_set <= 0){
  $msg = '敵を倒した。';
  $msg1 = '戦闘終了だ。';
  $npc_images = 'asset/icon/loose.png';
}elseif($npc_Access <= 0){
  $msg = '解析完了';
  $msg1 = '無力化に成功した。';
  $npc_images = 'asset/icon/search_out.png';
}
/*-------------------------------------------------------------------------*/
//終了フラグ
if($npc_hp_set <= 0 || $npc_Access <= 0) {
  $endflag = 1;
}elseif($pl_hp_set <= 0 || $pl_Access <= 0){
  $endflag = 1;
}
else{
  $endflag = 2;
}
/*-------------------------------------------------------------------------*/
?>



<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>戦闘画面</title>
  <link rel="icon" href="assets/favicon.ico.png">
  <!--jQuery-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <!--Javascript-->
  <script src='js/main.js'></script>
  <!--リセットCSS-->
  <link rel="stylesheet" type="text/css" href="css/reset.css"/>
  <!--CSS-->
  <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>

<body class ="noise">
<!---------------------------------------------------------------------------------------------------->
<!-- loading画面 -->
<div id="js-loader" class="loader"></div>
<!---------------------------------------------------------------------------------------------------->
<div class="top_line">
<div>
<!--ステータス一覧-->
<div class="target">
  <!--ここに記入する-->
    <!--ステータス一覧-->
    <div class="pl_information">
      <!--NPCステータス-->
      <p>シナリオ進行度: <?=$now_page+1?>/<?=$end_page?></p>
      <h1>NPCステータス</h1>
      <div class="status">
        <p>キャラクター名: <?=$npc_name?></p>
        <p>【こうげき】: <?=$npc_attack?></p>
        <p>【たふねす】: <?=$npc_toughness?></p>
        <p>【すばやさ】: <?=$npc_speed?></p>
        <p>【きようさ】: <?=$npc_technic?></p>
        <p>【そうぞう】: <?=$npc_imagination?></p>
        <p>【ついせき】: <?=$npc_chase?></p>
        <p>接続率 : <?=$npc_Access_power?>%</p>
        <p>会心率 : <?=$npc_critical?>%</p>
        <p>速度 : <?=$npc_round?></p>
        <p>通常攻撃成功率 : <?=$npc_battle?>%</p>
        <p>(攻撃力 : 1d<?=$npc_attack?>)</p>
        <p>調査成功率 : <?=$npc_search?>%</p>
      </div>
      <div>
      <p><?=$npc_name?>のHP : <?=$npc_hp_set?></p>
          <meter id="fuel"
                  min="0" max="<?=$npc_hp?>"
                  value="<?=$npc_hp_set?>">
                at <?=$npc_hp_set?>/<?=$npc_hp?>
          </meter>
          <p><?=$npc_name?>の接続率 : <?=$npc_Access?>%</p>
                    <!--
          <meter id="fuel"
                min="0" max="<?=$npc_Access_power?>"
                value="<?=$npc_Access?>">
              at <?=$npc_Access?>/<?=$npc_Access_power?>
          </meter>
          -->
      </div>
      <!--ステータス-->
      <h1>PLステータス</h1>
      <div class="status">
        <p>キャラクター名: <?=$pl_name?></p>
        <p>【こうげき】: <?=$pl_attack?></p>
        <p>【たふねす】: <?=$pl_toughness?></p>
        <p>【すばやさ】: <?=$pl_speed?></p>
        <p>【きようさ】: <?=$pl_technic?></p>
        <p>【そうぞう】: <?=$pl_imagination?></p>
        <p>【ついせき】: <?=$pl_chase?></p>
        <p>接続率 : <?=$pl_Access_power?>%</p>
        <p>会心率 : <?=$pl_critical?>%</p>
        <p>速度 : <?=$pl_round?></p>
        <p>通常攻撃成功率 : <?=$pl_battle?>%</p>
        <p>(攻撃力 : 1d<?=$pl_attack?>)</p>
        <p>調査成功率 : <?=$pl_search?>%</p>
      </div>
      <div>            
            <p><?=$pl_name?>のHP : <?=$pl_hp_set?></p>
          <meter id="fuel"
                min="0" max="<?=$pl_hp?>"
                value="<?=$pl_hp_set?>">
              at <?=$pl_hp_set?>/<?=$pl_hp?>
          </meter>
          <p><?=$pl_name?>の接続率 : <?=$pl_Access?>%</p>
          <!--
          <meter id="fuel"
                min="0" max="<?=$pl_Access_power?>"
                value="<?=$pl_Access?>">
              at <?=$pl_Access?>/<?=$pl_Access_power?>
          </meter>
          -->
          </div>
  </div>
  </div>
<button class="skew-button" class="button">ステータス</button>
</div>
<!--戦闘画面-->
<div class="straight_line">
  <div class="top_line">
  <img src="<?=$npc_images?>" alt="npcサンプル" width="500" height="500">
  <img src="<?=$pl_images_set?>" alt="PLサンプル" width="500" height="500">
  </div>
  <!--
  <img class="example16" src="<?=$scene_image_now?>" alt="enemyサンプル" width="960" height="540" >
  -->
  <div class="msg_window">
    <div>メッセージ</div>
    <div><?=$msg?></div>
    <div><?=$msg1?></div>
    <div><?=$msg2?></div>        
    </div>
</div>    
<!--コマンド選択バー-->
<div class="pl_information">
<form enctype="multipart/form-data" action="./play_game.php" method="POST">
      <legend>コマンド入力</legend>
      <div class="side_line">
      <!--隠しデータ-->            
        <!--PL隠しデータ-->
        <input type="hidden" name="pl_hp" value="<?=$pl_hp_set?>">
        <input type="hidden" name="pl_Access" value="<?=$pl_Access?>">
        <!--NPC隠しデータ-->
        <input type="hidden" name="npc_hp" value="<?=$npc_hp_set?>">
        <input type="hidden" name="npc_Access" value="<?=$npc_Access?>">
        <!--ゲーム進行度隠しデータ-->
        <input type="hidden" name="now_page" value="<?=$now_page?>">
      </div>
      <div class="straight_line">
        <!--選択-->
        <?php if($scene_event_type == 2){ ?>
        <button name="battle_command" value="0" class="skew-button" onclick="location.href = 'index.php'">次のシーンへ</button>
        <?php }else{ ?>
        <?php if($endflag == 2){ ?>
        <button name="battle_command" value="2" class="skew-button" onclick="location.href = 'index.php'">近接攻撃</button>
        <button name="battle_command" value="3" class="skew-button" onclick="location.href = 'index.php'">スキル攻撃</button>
        <button name="battle_command" value="4" class="skew-button" onclick="location.href = 'index.php'">調査</button>
        <button name="battle_command" value="5" class="skew-button" onclick="location.href = 'index.php'">待機</button>
        <!--
        <p>アイテム残数 : <?=$heel_item?></p>
        <?php if($heel_item != 0){ ?>
        <button name="battle_command" value="5">回復する</button>
        <?php } ?>
        -->
        <?php }elseif($endflag == 1){?>
        <button name="battle_command" value="9" class="skew-button" onclick="location.href = 'index.php'">次のシーンへ</button>
        <?php }} ?>
      </div>
  </form>
  <button class="skew-button" onclick="location.href = 'index.php'">ゲームをやめる</button>
</div>
</div>
</body>

</html>