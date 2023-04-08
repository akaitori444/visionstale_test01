<?php include('login_set.php'); 
/*セッション開始、ログインチェック、function読み込み、DBチェック、セッション定義*/ ?>
<?php
/*
//確認用
echo('<pre>');
echo var_dump($_SESSION);
echo var_dump($result);
echo var_dump($result1);
echo('<pre>');
exit();
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
<div class="white_frame">
  <div  class="straight_line">
    <div>
    <p>ゲームクリア</p>
    <button class="skew-button" onclick="location.href = 'index.php'"><span>メニューに戻る</span></button>
    </div>
    <div>
      <?php if(isset($play_character)){ ?>
      <?php foreach ($my_result as $record): ?>
        <img src="<?php echo $record["save_path"] ?>" alt="PL" width="100" height="100">
        <p>マイキャラクター:<?php echo $record["character_name"] ?></p>
        <?php endforeach; }else{?>
        <p>自分のキャラクターを選ぼう</p>
        <button class="skew-button" onclick="location.href = 'list_character.php'"><span>キャラを見る</span></button>
        <?php }?>
    </div>
    </div>
</div>

</body>

  

</html>