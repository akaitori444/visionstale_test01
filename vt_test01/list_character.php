<?php include('login_set.php'); 
/*セッション開始、ログインチェック、function読み込み、DBチェック、セッション定義*/ ?>
<?php
/*---------------------------------------------------------------------------*/
//character_game_dataの順番変更、検索機構
/*---------------------------------------------------------------------------*/
$list_name = 'character_game_data'; 
$search_id = 'id';
$search_name = 'character_name';
list($result, $search_term, $listorder ,$pages ,$now, $sql_check) = searchandorder($list_name, $search_id, $search_name);
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
  <!---------------------------------------------------------------------------------------------------->
  <!-- ページ移行 -->
  <br>
  <br>
  <div class="white_frame">
    <button class="skew-button" onclick="location.href = 'maker_character.php'">キャラクターを作る</button>
    <button class="skew-button" onclick="location.href = 'index.php'">メニューに戻る</button>
  </div>
  <div class="straight_line">
  <!---------------------------------------------------------------------------------------------------->
    <div class="white_frame">
    <h1>キャラクターリスト</h1>
    <div class="straight_line">
    <div>
      <?php foreach ($result as $record): ?>
      <form class="side_line" action="list_character_pickup.php" method="post">
        <div class="line_frame">
          <?php //キャラクター表示
            echo "<img src='$record[save_path]' alt='logo' alt='$record[save_path]' width='100' height='100'>";
            echo '<br>';
            echo '<p>名前：'.$record["character_name"].'</p>';
            echo '<p>制作者：'.$record["character_name"].'</p>';
            echo '<br>';
            $pickup_character_id =$record["character_id"];?>
          <input type="hidden" name="pickup_character_id" value="<?=$pickup_character_id?>">
        </div>
        <div><button class="skew-button">もっと見る</button></div>
      </form>
      <?php endforeach; ?>
    </div>
    </div>
    <!--ページネーションを表示-->
    <br>
    <?php for ( $n = 1; $n <= $pages; $n ++){
            if ( $n == $now ){
                echo "<span style='padding: 5px;'>$now";
            }else{
                echo "<a href='./list_character.php?page_id=$n' style='padding: 5px;'>$n</a>";    
            }
        }
    ?>
    </div>
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