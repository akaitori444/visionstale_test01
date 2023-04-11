<?php include('login_set.php'); 
/*セッション開始、ログインチェック、function読み込み、DBチェック、セッション定義*/ ?>

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
<button class="skew-button" onclick="location.href = 'list_character.php'">キャラクターを見る</button>
<button class="skew-button" onclick="location.href = 'index.php'">メニューに戻る</button>
</div>
<div class="white_frame">
  <!---------------------------------------------------------------------------------------------------->
  <!--タイトル-->
  <div>
    <div class="top">
      <div class="title">キャラクター作成</div>
    </div>
  </div>
  <!---------------------------------------------------------------------------------------------------->
  <dvi class="straight_line">
    <form enctype="multipart/form-data" action="./upload_character.php" method="POST">
        <h1>キャラクター名入力*</h1>
        <p>あなたのキャラクターデータを入力してください</p>
        <div>
          名前: <input type="text" name="name">
        </div>

        <h1 class="margin_top">イメージ*</h1>
        <p>キャラクターの画像を入力してください</p>
        <p>推奨サイズ1MB以下、アスペクト比1:1</p>
        <div class="file-up">
          <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
          <input name="img" type="file" accept="image/*" />
        </div>

        <h1>フレーバーテキスト*</h1>
        <p>キャラクターの説明を入力してください</p>
        <div>
        <textarea
        name="caption"
        placeholder="キャプション(140文字以下)"
        id="caption"
        ></textarea>
        </div>
        
        <h1>スペック*</h1>
        <p>キャラクターのスペック6段階評価で決めてください</p>
        <p>能力が高いほど強くなりますが行動の成功率が下がります</p>
        <div class="side_line">
          <div>こうげき:</div>
          <select name="attack">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3" selected>3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
          </select>
        </div>
        <div class="side_line">
          <div>たふねす:</div>
          <select name="toughness">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3" selected>3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
          </select>
        </div>
        <div class="side_line">
          <div>すばやさ:</div>
          <select name="speed">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3" selected>3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
          </select>
        </div>
        <div class="side_line">
          <div>きようさ:</div>
          <select name="technic">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3" selected>3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
          </select>
        </div>
        <div class="side_line">
          <div>そうぞう:</div>
          <select name="imagination">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3" selected>3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
          </select>
        </div>
        <div class="side_line">
          <div>ついせき:</div>
          <select name="chase">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3" selected>3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
          </select>
        </div>
        <h1>戦闘傾向*</h1>
        <p>NPC時の挙動を決めてください</p>
        <div class="side_line">
          <select name="battle_style">
            <option value="1" selected>バランス</option>
            <option value="2">攻撃</option>
            <option value="3">支援</option>
            <option value="4">補助</option>
            <option value="5">逃走</option>
          </select>
        </div>
        <div>
          <button class="skew-button">作成</button>
        </div>
    </form>
  </dvi>
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