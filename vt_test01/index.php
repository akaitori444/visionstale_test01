<?php include('login_set.php'); 
/*セッション開始、ログインチェック、function読み込み、DBチェック、セッション定義*/ ?>
<?php
/*---------------------------------------------------------------------------*/
//ゲーム外セッションアウト
unset($_SESSION['play_scenario_date']);
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

<body>
<br>
<br>
<br>
<div class ="noise">  
  <!-- 選択ボタン -->
  <div class="white_frame">
    <h1>作る</h1>
    <div class = "padding_short">
      <div class = "side_line">
        <div class = "straight_line">
          <div class = "straight_line">
            <div  class="padding_5">
              <img src="asset/icon/scenario.png" alt="icon" width="80" height="80">
            </div>
            <button class="skew-button" onclick="location.href = 'maker_scenario.php'"><span>シナリオを作る</span></button>
          </div>
          <div class = "straight_line">
            <div  class="padding_5">
              <img src="asset/icon/character.png" alt="icon" width="80" height="80">
            </div>
            <button class="skew-button" onclick="location.href = 'maker_character.php'"><span>キャラクターを作る</span></button>
          </div>
        </div>
        <div class = "straight_line">
          <div class = "straight_line">
            <div  class="padding_5">
              <img src="asset/icon/item.png" alt="icon" width="80" height="80">
            </div>
            <button class="skew-button" onclick="location.href = 'maker_item.php'"><span>アイテムを作る</span></button>
          </div>
          <div class = "straight_line">
            <div  class="padding_5">
              <img src="asset/icon/tag.png" alt="icon" width="80" height="80">
            </div>
            <button class="skew-button" onclick="location.href = 'maker_tag.php'"><span>タグを作る</span></button>
          </div>
        </div>
      </div>
    </div>
    <br>
    <div>
      <h1>遊ぶ</h1>
      <div class = "padding_short">
        <button class="skew-button menu_set" onclick="location.href='play_scenario.php'"><span>シナリオを選ぶ</span></button>
      </div>
    </div>
    <br>
  </div>
</div>
<!---------------------------------------------------------------------------------------------------->
<?php include('set.php');?>
</body>
</html>