<?php include('login_set.php'); 
/*セッション開始、ログインチェック、function読み込み、DBチェック、セッション定義*/ ?>
<?php
/*---------------------------------------------------------------------------*/
//scenario_dataの順番変更、検索機構
/*---------------------------------------------------------------------------*/
$list_name = 'scenario_data'; 
$search_id = 'scenario_id';
$search_name = 'scenario_name';
list($result, $search_term, $listorder ,$pages ,$now) = searchandorder($list_name, $search_id, $search_name);
/*---------------------------------------------------------------------------*/
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
    <button class="skew-button" onclick="location.href='list_scenario.php'">シナリオを見る</button>
    <button class="skew-button" onclick="location.href='index.php'">メニューに戻る</button>
  </div>
<!---------------------------------------------------------------------------------------------------->
  <div class="white_frame">
    <?php if(isset($_SESSION['play_character'])){ ?>
    <?php foreach ($my_result as $record): ?>
      <img src="<?php echo $record["save_path"] ?>" alt="PL" width="100" height="100">
      <p>マイキャラクター:<?php echo $record["character_name"] ?></p>
      <?php endforeach; }else{?>
      <p>自分のキャラクターを選ぼう</p>
      <button onclick="location.href='list_character.php'">キャラを見る</button>
      <?php }?>
  </div>
  <!---------------------------------------------------------------------------------------------------->
  <div class="white_frame">
    <h1>シナリオリスト</h1>
    <div class="straight_line space-evenly">
      <?php foreach ($result as $record): ?>
      <form class="side_line" action="play_game_start.php" method="post">
        <div class='padding_50'>
          <?php //シナリオ表示
            echo "<img src='$record[scenario_image]' alt='logo' alt='$record[scenario_image]' width='240' height='135'>";
            echo '<br>';
            echo '<p>シナリオ名：'.$record["scenario_name"].'</p>';
            echo '<br>';?>
          <input type="hidden" name="pickup_scenario_id" value="<?=$pickup_scenario_id?>">
          <input type="hidden" name="character_id" value="<?=$my_result[0]["character_id"]?>">
          <input type="hidden" name="scenario_id" value="<?= $record["scenario_id"]?>">
        </div>
        <div>
          <button class="skew-button" onclick="location.href = 'index.php'">このシナリオを遊ぶ</button>
        </div>
      </form>
      <?php endforeach; ?>
    
    </div>
    <!--ページネーションを表示-->
    <br>
    <?php for ( $n = 1; $n <= $pages; $n ++){
            if ( $n == $now ){
                echo "<span style='padding: 5px;'>$now";
            }else{
                echo "<a href='./list_scenario.php?page_id=$n' style='padding: 5px;'>$n</a>";    
            }
        }
    ?>
  </div>
</div>
<!---------------------------------------------------------------------------------------------------->
<!-- 画面右 -->
<!-- ゲーム内情報、検索機構 -->
<div class="straight_line sidebar">
<?php include('set_right.php');?>
<?php
//検索システムの適用ページ
$list_character = 'list_character.php';?>
<?php include('search.php');?>
</div>

</div>
<!---------------------------------------------------------------------------------------------------->
<!-- top -->
<?php include('set_top.php');?>
</body>

</html>