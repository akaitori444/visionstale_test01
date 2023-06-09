<?php include('login_set.php'); 
/*セッション開始、ログインチェック、function読み込み、DBチェック、セッション定義*/ ?>
<?php
/*---------------------------------------------------------------------------*/
//character_game_dataの順番変更、検索機構
/*---------------------------------------------------------------------------*/
$list_name = 'item_data'; 
$search_id = 'item_id';
$search_name = 'item_name';
list($result, $search_term, $listorder ,$pages ,$now) = searchandorder($list_name, $search_id, $search_name);
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
    <button class="skew-button" onclick="location.href = 'maker_item.php'">アイテムを作る</button>
    <button class="skew-button" onclick="location.href = 'index.php'">メニューに戻る</button>
  </div>
  <!---------------------------------------------------------------------------------------------------->
  <div class="straight_line">
  <!---------------------------------------------------------------------------------------------------->
    <div class="white_frame">
    <h1>アイテムリスト</h1>
    <div class="straight_line">
    <div>
      <?php foreach ($result as $record): ?>
      <form class="side_line" action="list_character_pickup.php" method="post">
        <div class="line_frame">
          <?php //キャラクター表示
            echo "<img src='$record[item_image]' alt='logo' alt='$record[item_image]' width='100' height='100'>";
            echo '<br>';
            echo '<p>アイテム名：'.$record["item_name"].'</p>';?>
        </div>
        <div>
        <?php
            if($record["item_type"] == 1){
              echo "系統:HP回復<br>使用することでHPを6回復する";
            }elseif($record["item_type"] == 2){
              echo "系統:接続率回復<br>使用することで接続率を30回復する";
            }elseif($record["item_type"] == 3){
              echo "系統:物理武器<br>使用することで相手HPに4ダメージ";
            }elseif($record["item_type"] == 4){
              echo "系統:特殊武器<br>使用することで相手接続率に20ダメージ";
            };
            echo '<br>';?>
        </div>
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
                echo "<a href='./list_item.php?page_id=$n' style='padding: 5px;'>$n</a>";    
            }
        }
    ?>
    </div>
        
    <!---------------------------------------------------------------------------------------------------->
    
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