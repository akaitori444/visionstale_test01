<?php include('login_set.php'); 
/*セッション開始、ログインチェック、function読み込み、DBチェック、セッション定義*/ ?>
<?php
/*---------------------------------------------------------------------------*/
//pickup_character_id確認機構(なければリストに返す)
if(isset($_POST['pickup_character_id'])){
  $pickup_character_id = $_POST['pickup_character_id'];
}else{
  $_SESSION['output_message'] = "キャラクターデータが選択されていません";
  header("location: list_character.php");
  exit();
}
/*---------------------------------------------------------------------------*/
$pdo = connect_vt_db();
/*---------------------------------------------------------------------------*/
//character_game_dataの順番変更、検索機構
$search_term = $pickup_character_id;
$sql = "SELECT * FROM character_game_data LEFT OUTER JOIN character_spec_set ON character_spec_id = character_id WHERE character_id = '$search_term'";
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
//ステータス定義
//PL
$character_name = $result[0]["character_name"];
$save_path = $result[0]["save_path"];
//スペック
$attack = $result[0]["attack"];
$toughness = $result[0]["toughness"];
$speed = $result[0]["speed"];
$technic = $result[0]["technic"];
$imagination = $result[0]["imagination"];
$chase = $result[0]["chase"];
/*---------------------------------------------------------------------------*/
//接続率計算
$spec = [$attack, $toughness, $speed, $technic, $imagination, $chase];
$total = 0;
foreach ($spec as $record):
  if($record > 3){
    $count = $record * 2 - 3;
  }else{
    $count = $record;
  }
  $total += $count;
endforeach;
$Access_power = 100 - $total;
/*---------------------------------------------------------------------------*/
//ステータス
$hp = $toughness * 2 + 6 ;
$critical = $technic * 3 ;
$round = ($speed+$technic) * 5 + $speed;
$default_battle = ($attack+$toughness+$technic) * 6;
if($Access_power < $default_battle){
  $default_battle = $Access_power;
}
$default_search = ($technic+$imagination+$chase) * 6;
if($Access_power < $default_search){
  $default_search = $Access_power;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VisionsTale</title>
  <link rel="icon" href="asset/icon/favicon.vt.png">
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
<!-- 画面 -->
<div class = "top_line">
<!---------------------------------------------------------------------------------------------------->
<!-- 画面左 -->
<!-- メッセージ、PL情報 -->
<div class="straight_line sidebar">
<?php include('set_left.php');?>
</div>
<!---------------------------------------------------------------------------------------------------->
<div class = "main-menu">
<!-- メイン画面 -->
<br>
<br>
<div class="white_frame">
  <button class="skew-button" onclick="location.href = 'list_character.php'">キャラリストに戻る</button>
  <button class="skew-button" onclick="location.href = 'index.php'">メニューに戻る</button>
</div>
  <div class="white_frame">
  <div  class="straight_line">
    <h1><?php echo $character_name ?>のデータ</h1>
      <?php foreach ($result as $record): ?>
          <img src="<?php echo $record["save_path"] ?>" alt="PL" width="100" height="100">
          <p>キャラクター名：<?php echo $record["character_name"] ?></p>
          <p>接続率：<?php echo $Access_power?>％</p>
          <p>こうげき：<?php echo $record["attack"] ?></p>
          <p>たふねす：<?php echo $record["toughness"] ?></p>
          <p>すばやさ：<?php echo $record["speed"] ?></p>
          <p>きようさ：<?php echo $record["technic"] ?></p>
          <p>そうぞう：<?php echo $record["imagination"] ?></p>
          <p>ついせき：<?php echo $record["chase"] ?></p>
          
          <?php if(@$play_character == @$pickup_character_id){ ?>
        <!--登録解除-->
        <form enctype="multipart/form-data" action="./upload_character_pickup.php" method="POST">
          <p><?php echo $record["character_name"]?>をマイキャラクターに選択中</p>
          <input type="hidden" name="character_choice" value="0">
          <div><button class="skew-button">登録を解除</button></div>
        </form>
        <?php }else{?>
        <!--登録-->
        <form enctype="multipart/form-data" action="./upload_character_pickup.php" method="POST">
          <input type="hidden" name="pickup_character_id" value="<?=$_POST['pickup_character_id']?>">
          <input type="hidden" name="character_choice" value="1">
          <p>自分のキャラクターを選ぼう</p>
          <div><button class="skew-button">マイキャラクターに登録</button></div>
        </form>
        <form enctype="multipart/form-data" action="./maker_character_plus_profile.php" method="POST">
          <input type="hidden" name="pickup_character_id" value="<?=$_POST['pickup_character_id']?>">
          <div><button class="skew-button">プロフィールを編集する</button></div>
        </form>
        <form enctype="multipart/form-data" action="./maker_character_plus_item.php" method="POST">
          <input type="hidden" name="pickup_character_id" value="<?=$_POST['pickup_character_id']?>">
          <div><button class="skew-button">アイテムを持たせる</button></div>
        </form>

      <?php }?>
    </div>    
        <?php endforeach; ?>
    <!--
    <button class="skew-button" onclick="location.href='maker_character_plus_tag.php'">タグをつける</button>
    -->
    <br>
    <!--シェアボタン-->
    <div class="side_line">
      <p class="padding_short">このキャラクターをみんなと共有しよう</p>
      <a href="https://twitter.com/share?ref_src=twsrc%5Etfw"
          class="twitter-share-button"
          data-text="「<?php echo $character_name?>」はVisionsTaleで遊んでいます!"
          data-hashtags="visionstale"
          data-size="large"
          data-url="https://bokuwa.sakura.ne.jp/vt_test01/vt_login.php">
      Tweet</a>
      <!--Twitter連携-->
      <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>


  </div>
</div>
<!---------------------------------------------------------------------------------------------------->
<!-- 画面右 -->
<!-- ゲーム内情報、検索機構 -->
<div class="straight_line sidebar">
<?php include('set_right.php');?>
</div>

</div>
<!---------------------------------------------------------------------------------------------------->
<!-- top -->
<?php include('set_top.php');?>
</body>

</html>