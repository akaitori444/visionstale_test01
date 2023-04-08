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

<body>
<br>
<br>
<br>
<div class="white_frame">
<button class="skew-button" onclick="location.href = 'list_scenario.php'"><span>シナリオを見る</span></button>
  <button class="skew-button" onclick="location.href = 'index.php'"><span>メニューに戻る</span></button>
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
            <h1>名前</h1>
            <div>シナリオの名前: <input type="text" name="name"></div>
          </div>
          <div> 
            <h1>シナリオイメージ</h1>
            <p>シナリオののイメージ画像を入力してください</p>
            <p>推奨サイズ:960*540px</p>
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
        </div>
    </div>
        <!-------------------------------------------------------------------------------------------------------------------------------->
        <div class='straight_line'><!-- リセット＆作成 -->
          <div>
            <input type="reset" value="リセットする">
            <button>シナリオを作成</button>
          </div>
        </div>
      </form>
</div>
<?php include('set.php');?>
</body>
</html>

