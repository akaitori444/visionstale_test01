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
<button class="skew-button" onclick="location.href = 'list_scenario.php'">シナリオを見る</button>
  <button class="skew-button" onclick="location.href = 'index.php'">メニューに戻る</button>
</div>
  <div class="white_frame">
  <h1>シナリオ作成</h1>
  <p>キャラクターやアイテムを使ってシナリオを作りましょう</p>
  <dvi>
    <div>
      <form enctype="multipart/form-data" action="./upload_scenario.php" method="POST">
        <!-------------------------------------------------------------------------------------------------------------------------------->
        <div class="straight_line"><!-- 詳細データ作成 -->
          <div>
            <h1>シナリオ名入力*</h1>
            <div>名前: <input type="text" name="name"></div>
            <br>
            <h1>シナリオイメージ*</h1>
            <p>シナリオののイメージ画像を入力してください</p>
            <p>推奨サイズ:960*540px</p>
            <div class="file-up">
                <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
                <input name="img" type="file" accept="image/*" />
            </div>
            <br>
            <h1>説明*</h1>
            <p>シナリオの説明文、ゲーム選択時に表示されます</p>
            <div>
            <textarea
              name="caption"
              placeholder="キャプション(140文字以下)"
              id="caption"
            ></textarea>
            </div>
          </div>
        </div>
    </div>
        <!-------------------------------------------------------------------------------------------------------------------------------->
        <div class='straight_line'><!-- リセット＆作成 -->
        <div>
          <button class="skew-button">作成</button>
        </div>
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
  <!---------------------------------------------------------------------------------------------------->
</div>
<!---------------------------------------------------------------------------------------------------->
<!-- top -->
<?php include('set_top.php');?>
</body>

</html>

