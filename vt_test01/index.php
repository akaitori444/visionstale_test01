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
<!-- main -->
  <div class="white_frame">
    <h1>「VisionsTale」とは？</h1>
    <p>「VisionsTale」とはあなたの思い描く夢を"物語"として可視化する試みです。</p>
    <br>
    <h1>作る</h1>
    <p>物語は『キャラクター』と『シナリオ』、アクセントに『アイテム』を加えることで簡単に作りだせます。</p>
    <p>このゲームではそれらの要素を『自作』したり『シェア』することで簡単に用意することが出来ます。</p>
    <p>あなただけの物語をアウトプットして世界に届けましょう。</p>
    <div class = "side_line">
      <!--<div class = "straight_line">-->
        <!--キャラクター-->
        <div class = "straight_line padding_5 line_frame">
          <div  class="padding_5">
            <img src="asset/icon/character.png" alt="icon" width="80" height="80">
          </div>
          <button class="skew-button" onclick="location.href = 'list_character.php'">キャラクターを見る</button>
          <button class="skew-button" onclick="location.href = 'maker_character.php'">キャラクターを作る</button>
        </div>
        <!--シナリオ-->
        <div class = "straight_line padding_5 line_frame">
          <div  class="padding_5">
            <img src="asset/icon/scenario.png" alt="icon" width="80" height="80">
          </div>
          <button class="skew-button" onclick="location.href = 'list_scenario.php'">シナリオを見る</button>
          <button class="skew-button" onclick="location.href = 'maker_scenario.php'">シナリオを作る</button>
        </div>
          <!--アイテム-->
          <div class = "straight_line padding_5 line_frame">
          <div  class="padding_5">
            <img src="asset/icon/item.png" alt="icon" width="80" height="80">
          </div>
          <button class="skew-button" onclick="location.href = 'list_item.php'">アイテムを見る</button>
          <button class="skew-button" onclick="location.href = 'maker_item.php'">アイテムを作る</button>
        </div>
      <!--</div>-->
      <!--<div class = "straight_line">-->
        <!--タグ機能-->
        <!--
        <div class = "straight_line">
          <div  class="padding_5">
            <img src="asset/icon/tag.png" alt="icon" width="80" height="80">
          </div>
          <button class="skew-button" onclick="location.href = 'maker_tag.php'">タグを作る</button>
        </div>
        -->
      <!--</div>-->
    </div>
    <br>
    <div>
      <h1>遊ぶ</h1>
      <p>『キャラクター』と『シナリオ』が揃えばゲームを遊ぶことが出来ます。</p>
      <p>『キャラクター』との出会いの中で物語を広げていきましょう。</p>
      <div class = "side_line">
        <!-- My character -->
        <div class="straight_line line_frame">
          <div class="padding_short">
          <?php if(isset($play_character)){ ?>
          <?php foreach ($my_result as $record): ?>
            <img src="<?php echo $record["save_path"] ?>" alt="PL" width="100" height="100">
            <p>マイキャラクター:<?php echo $record["character_name"] ?></p>
            <?php endforeach; }else{?>
            <p>自分のキャラクターを選ぼう</p>
            <button class="skew-button" onclick="location.href='list_character.php'">キャラを見る</button>
            <?php }?>
          </div>
        </div>
        <div class = "padding_short">
          <button class="skew-button menu_set" onclick="location.href='play_scenario.php'">シナリオを選ぶ</button>
        </div>
      </div>
    </div>
    <br>
  </div>
</div>
<!---------------------------------------------------------------------------------------------------->
<!-- 画面右 -->
<!-- ゲーム内情報、検索機構 -->
<div class="straight_line sidebar">
<?php include('set_right.php');?>
</div>
<!---------------------------------------------------------------------------------------------------->
<!-- top -->
<?php include('set_top.php');?>
</body>
</html>