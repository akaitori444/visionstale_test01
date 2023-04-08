<?php include('login_set.php'); 
/*セッション開始、ログインチェック、function読み込み、DBチェック、セッション定義*/ ?>
<?php
/*---------------------------------------------------------------------------*/
//scenario_dataの順番変更、検索機構
/*---------------------------------------------------------------------------*/
$list_name = 'scenario_data'; 
$search_id = 'scenario_id';
$search_name = 'scenario_name';
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

<body>
<br>
<br>
<br>
<div class="white_frame">
  <button class="skew-button" onclick="location.href = 'maker_scenario.php'"><span>シナリオを作る</span></button>
  <button class="skew-button" onclick="location.href = 'index.php'"><span>メニューに戻る</span></button>
</div>
<div class="straight_line">
  <div class="white_frame">
  <h1>シナリオリスト</h1>
  <div class="straight_line">
  <div>
    <?php foreach ($result as $record): ?>
    <form class="side_line" action="list_scenario_pickup.php" method="post">
      <div>
        <?php //シナリオ表示
          echo "<img src='$record[scenario_image]' alt='logo' alt='$record[scenario_image]' width='240' height='135'>";
          echo '<br>';
          echo '<p>キャラクター名：'.$record["scenario_name"].'</p>';
          echo '<br>';
          $scenario_id =$record["scenario_id"];?>
        <input type="hidden" name="scenario_id" value="<?=$scenario_id?>">
      </div>
      <div><button>もっと見る</button></div>
    </form>
    <?php endforeach; ?>
  </div>
  </div>
  <!--ページネーションを表示-->
  <br>
  <?php for ( $n = 1; $n <= $pages; $n ++){
          if ( $n == $now ){
              echo "<span style='padding: 5px;'>$now</span>";
          }else{
              echo "<a href='./list_scenario.php?page_id=$n' style='padding: 5px;'>$n</a>";    
          }
      }
  ?>
  </div>
  <!---------------------------------------------------------------------------------------------------->
</div>
<?php include('set.php');?>
<?php
//検索システムの適用ページ
$list_character = 'list_scenario.php';?>
<?php include('search.php');?>
</body>
</html>