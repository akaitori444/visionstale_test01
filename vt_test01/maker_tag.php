<?php include('login_set.php'); 
/*セッション開始、ログインチェック、function読み込み、DBチェック、セッション定義*/ ?>
<?php
/*---------------------------------------------------------------------------*/
$list_name = 'tag'; 
$search_id = 'tag_id';
$search_name = 'tag_name';
$pdo = connect_vt_db();
list($result, $search_term, $listorder) = searchandorder($list_name, $search_id, $search_name);
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
<div class="white_frame">
  <button class="skew-button" onclick="location.href = 'index.php'"><span>メニューに戻る</span></button>
</div>
  <div class="white_frame">
  <div  class="straight_line">
    <!---------------------------------------------------------------------------------------------------->
    <!--順列＆検索機構-->
    <?php $output = "maker_tag.php"?><!--送り先指定-->
    <div>
      <form action="<?php $output?>" method="post">
      <h1>順番</h1>
        <p>現在の並び:<?php echo $listorder ?></P>
          <br>
          <select name="order">
            <option value="1">ID順</option>
            <option value="2">ID逆順</option>
            <option value="3">あいうえお順</option>
            <option value="4">あいうえお逆順</option>
            <option value="5" selected>ランダム表示</option>
          </select><input type="submit">
      </form>
      <h1>検索</h1>
      <?php if(@$_POST["search_term"] != ""){?>
        <p>検索ワード:<?php echo $search_term?></P>
        <?php }?>
      <form action="<?php $output?>" method="post">
              <br>
              Name:<input type="text" name="search_term"><input type="submit">
              <input type="hidden" name="order" value="1">
      </form>
    </div>
    <!---------------------------------------------------------------------------------------------------->
    <h1>タグ入力</h1>
    <form action="upload_tag.php" method="post">
      <br>
      <input type="text" name="tag_name"><input type="submit">
    </form>
    <h1>タグリスト</h1>
    <table>
      <thead>
        <tr>
          <th>タグ名</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($result as $record): ?>
          <tr>
          <td><?php echo $record["tag_name"] ?></td>
          <td><?php 
          $character_name = $record["tag_name"];?>
          <input type="hidden" name="tag_name" value="<?=$character_name?>">
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  </div>
  <!--
  <div class="white_frame">
  <canvas id="mycanvas" width="800" height="600">
	Canvasに対応したブラウザを使って下さい。
  </canvas>
  </div>
  -->
  <script src='js/main.js'></script>
<?php include('set.php');?>
</body>

  

</html>