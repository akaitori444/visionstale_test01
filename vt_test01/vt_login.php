<?php
session_start();
$_SESSION['loading'] = true; // セッション変数'loading'にtrueを代入
include('functions.php');
/*-------------------------------------------------------------------------------*/
// メッセージを作成
/*-------------------------------------------------------------------------------*/
$random_message = Randommessage();
if(isset($_SESSION['output_message'])){
  $sessoin_message = $_SESSION['output_message'];
  unset($_SESSION['output_message']);
}else{
  $sessoin_message = '';
}
/*-------------------------------------------------------------------------------*/
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VisionsTale ログイン</title>
  <link rel="icon" href="asset/icon/favicon.vt.png">
  <!--jQuery-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    // ページが完全に読み込まれたときに実行される関数
    $(window).on('load', function() {
      $('#loading').hide(); // ローディング画像を非表示にする
      <?php unset($_SESSION['loading']); ?> // セッション変数'loading'を削除する
    });

    // ページが読み込まれたときに実行される関数
    $(document).ready(function() {
      <?php if(isset($_SESSION['loading'])): ?> // もしセッション変数'loading'がある場合
        $('#loading').show(); // ローディング画像を表示する
      <?php endif; ?>
    });
  </script>
  <!--CSS-->
  <!--リセットCSS-->
  <link rel="stylesheet" type="text/css" href="css/reset.css"/>
  <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>

<body>

  <div class="white_frame">
    <!--メッセージ出力機構-->  
    <div class="straight_line">
    <div>--------------------------------------------------------------------------------------------------------------------</div>
      <br>
      <p class="big_font">
      <?php if($sessoin_message !== ''){
        echo $sessoin_message;
      }else{
        echo $random_message;    
      }?></p>
      <br>
      <div>--------------------------------------------------------------------------------------------------------------------</div>
    </div>
    <!-------------------->
    <div class="straight_line">
      
      <img src="asset/icon/favicon.vt.png" alt="logo">
      <div>
        <br>
        <p1>あなたの好きな物語を描きましょう</p1>
        <br>
        <br>
          <form action="vt_login_act.php" method="POST">
          <h1>ログイン</h1>
          <div class="straight_line">
            <br>
            <div>
              ユーザー名: <input type="text" name="username">
            </div>
            <div>
              パスワード: <input type="text" name="password">
            </div>
          </div>
          <div>
            <button>ログイン</button>
          </div>
          </form>
          <br>  
          <div>
          <button onclick="location.href='vt_register.php'">新規登録画面へ</button>
          </div>
        </div>
        <br>  
    </div>
  </div>
  <!-- ローディング画像 -->
  <img src="asset/gif/noise.gif" id="loading" style="display:none;">
</body>

</html>