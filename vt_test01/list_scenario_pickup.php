<?php include('login_set.php'); 
/*セッション開始、ログインチェック、function読み込み、DBチェック、セッション定義*/ ?>
<?php
/*---------------------------------------------------------------------------*/
//scenario_image確認機構(なければリストに返す)
if($_POST["scenario_id"] == ""){header("location: list_scenario.php");}
/*---------------------------------------------------------------------------*/
//0.シナリオデータ読み込み
/*---------------------------------------------------------------------------*/
//scenario_dataの順番変更、検索機構
$search_term = $_POST["scenario_id"];
$sql = "SELECT * FROM scenario_data WHERE scenario_id = '$search_term'";
$stmt = $pdo->prepare($sql);
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
// SQL作成&実行
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
/*---------------------------------------------------------------------------*/
//1.連携シーン数チェック
/*---------------------------------------------------------------------------*/
$search_scenario_id = $result[0]["scenario_id"];
$sql1 = "SELECT COUNT(*) FROM scene_set WHERE scene_connect = '$search_scenario_id'";
$stmt1 = $pdo->prepare($sql1);
try {
  $status1 = $stmt1->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
// SQL作成&実行
$result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
if($result1[0]["COUNT(*)"] = 0){
  $search_scene = 0;
}else{
  $search_scene = 1;
}
/*---------------------------------------------------------------------------*/
//2.シーンデータ読み込み
/*---------------------------------------------------------------------------*/
//sceneの順番変更、検索機構
$sql2 = "SELECT * FROM scenario_data LEFT OUTER JOIN scene_set ON scenario_id = scenario_connect LEFT OUTER JOIN scene ON scene_connect = scene_id WHERE scenario_id = '$search_term'";
$stmt2 = $pdo->prepare($sql2);
try {
  $status2 = $stmt2->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
// SQL作成&実行
$result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
/*---------------------------------------------------------------------------*/
/*
//確認用
echo('<pre>');
//var_dump($_POST);
//var_dump($result);
//var_dump($result1);
var_dump($result2);
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
<br>
<br>
<br>
<div class="white_frame">
  <button class="skew-button" onclick="location.href = 'list_scenario.php'"><span>シナリオを見る</span></button>
  <button class="skew-button" onclick="location.href = 'index.php'"><span>メニューに戻る</span></button>
</div>
<div class="white_frame">
<div class="straight_line">
  <div  class="side_line">
  <div class="straight_line">
      <?php foreach ($result as $record): ?>
        <div class="straight_line">
        <h1><?php echo $record["scenario_name"] ?>のデータ</h1>
        <img src="<?php echo $record["scenario_image"] ?>" alt="PL" width='240' height='135'>
        <p>シナリオ名：<?php echo $record["scenario_name"] ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  <!---------------------------------------------------------------------------------------------------->  
    <?php if(isset($result2[0]["id"])){foreach ($result2 as $record): ?>
      <!--シーンブロック-->
          <div class="straight_line">
            シーン順番：<?php echo $record["order_number"]+1 ?>
            <img src="<?php echo $record["scene_image"] ?>" alt="PL" width="100" height="100">
            <P>シーン名：<?php echo $record["scene_name"] ?></P>
          </div>
  <!---------------------------------------------------------------------------------------------------->
  <?php endforeach; }else{?>
    <p>シーンを作ってシナリオを完成させよう</p>
    <?php }?>
  </div>
  <div>
  <form action="./maker_scenario_plus_scene.php" method="POST">
  <input type="hidden" name="scenario_id" value="<?=$_POST["scenario_id"]?>">
  <button>シーンを作る</button>
  </form>
  <!--
  <button onclick="location.href='maker_scenario_plus_item.php'">報酬アイテムを選ぶ</button>
  -->  
  </div>
  </div>
</div>
<?php include('set.php');?>
</body>
</html>