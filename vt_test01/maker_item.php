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
  <button class="skew-button" onclick="location.href = 'list_item.php'">アイテムを見る</button>
  <button class="skew-button" onclick="location.href = 'index.php'">メニューに戻る</button>
</div>

  <div class="white_frame">
  <h1>アイテム作成</h1>
  <p>オリジナルのアイテムを作りましょう</p>
  <dvi class="straight_line">
  <!-------------------------------------------------------------------------------------------------------------------------------->
  <!--名称、画像、説明-->
    <form enctype="multipart/form-data" action="./upload_item.php" method="POST">
      <h1>名前</h1>
      <div>
          アイテムの名前: <input type="text" name="name">
      </div>
      <div> 
        <h1>イメージ</h1>
        <p>アイテムのイメージ画像を入力してください</p>
        <div class="file-up">
            <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
            <input name="img" type="file" accept="image/*" />
        </div>
        <h1>説明</h1>
        <div>
        <textarea
          name="caption"
          placeholder="キャプション(140文字以下)"
          id="caption"
        ></textarea>
        </div>
      </div>
  <!-------------------------------------------------------------------------------------------------------------------------------->
  <!--アイテム効果の選択-->
      <h1>アイテムの効果</h1>
      <div class="side_line">
        <select name="type">
          <option value="1" selected>HP回復</option>
          <p>HPを6回復する</p>
          <option value="2">接続率回復</option>
          <p>接続率を30回復する</p>
          <option value="3">物理武器</option>
          <p>使用することで相手HPに4ダメージ</p>
          <option value="4">特殊武器</option>
          <p>使用することで相手接続率に20ダメージ</p>
        </select>
      </div>
  <!-------------------------------------------------------------------------------------------------------------------------------->
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

