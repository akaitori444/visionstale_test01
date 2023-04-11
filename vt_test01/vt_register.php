<?php
session_start();
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
        <form action="vt_register_act.php" method="POST">
        <h1>ユーザー登録</h1>
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
          <button class="skew-button">新規登録</button>
        </div>
        </form>
        <br>  
            <div>
              <button class="skew-button" onclick="location.href='vt_login.php'">ログイン画面へ</button>
            </div>
      </div>
        <br>  
    </div>
  </div>
</body>

</html>