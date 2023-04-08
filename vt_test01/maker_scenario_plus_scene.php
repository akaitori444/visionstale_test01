<?php include('login_set.php'); 
/*セッション開始、ログインチェック、function読み込み、DBチェック、セッション定義*/ ?>
<?php
/*---------------------------------------------------------------------------*/
//scenario_image確認機構(なければリストに返す)
if(isset($_POST["scenario_id"])){
  $search_term = $_POST["scenario_id"];
  $_SESSION['output_message_type'] == 0;//成功メッセージ
  $_SESSION['output_message'] = 'シーンを追加していきましょう';  
  }elseif(isset($_SESSION["pickup_scenario_id"])){
    $search_term = $_SESSION["pickup_scenario_id"];  
    unset($_SESSION["pickup_scenario_id"]);
    $_SESSION['output_message_type'] == 0;//成功メッセージ
    $_SESSION['output_message'] = 'シーンを追加していきましょう';
  }else{
    $_SESSION['output_message_type'] == 1;//エラーメッセージ
    $_SESSION['output_message'] = '接続に失敗しました';
    header("location: list_scenario.php");
  }
/*---------------------------------------------------------------------------*/
//1.シナリオデータ読み込み
/*---------------------------------------------------------------------------*/
//scenario_dataの順番変更、検索機構
$sql1 = "SELECT * FROM scenario_data WHERE scenario_id = '$search_term'";
$stmt1 = $pdo->prepare($sql1);
try {
  $status = $stmt1->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
// SQL作成&実行
$result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
/*---------------------------------------------------------------------------*/
//2.連携シーン読み込み
/*---------------------------------------------------------------------------*/
//sceneの順番変更、検索機構
$sql2 = "SELECT * FROM scenario_data LEFT OUTER JOIN scene_set ON scenario_id = scenario_connect LEFT OUTER JOIN scene ON scene_connect = scene_id LEFT OUTER JOIN character_game_data ON actor_set_connect = character_id WHERE scenario_id = '$search_term'";
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
//character_game_dataの順番変更、検索機構
/*---------------------------------------------------------------------------*/
$list_name = 'character_game_data'; 
$search_id = 'id';
$search_name = 'character_name';
list($result, $search_term, $listorder ,$pages ,$now) = searchandorder($list_name, $search_id, $search_name);
/*---------------------------------------------------------------------------*/
/*
//確認用
echo('<pre>');
//echo var_dump($_POST);
echo var_dump($result2);
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
<!---------------------------------------------------------------------------------------------------->
<div class="white_frame">
  <div  class="side_line">
  <?php foreach ($result1 as $record): ?>
      <!--シナリオタイトルブロック-->
      <div class="straight_line">
      <p>シナリオ</p>
      <img src="<?php echo $record["scenario_image"] ?>" alt="PL" width="96" height="54">
      <p>シナリオ名：<?php echo $record["scenario_name"] ?></p>
      <?php $scenario_id = $record["scenario_id"] ?>
    </div>
  <?php endforeach; ?>
  <?php if(isset($result2[0]["id"])){foreach ($result2 as $record): ?>
    <!--シーンブロック-->
    <div class="straight_line">
      シーン順番：<?php echo $record["order_number"]+1 ?>
      <img src="<?php echo $record["scene_image"] ?>" alt="PL" width="100" height="100">
      <P>シーン名：<?php echo $record["scene_name"] ?></P>
      <?php if(isset($record["character_id"])){?>
      <P>登場キャラ:<?php echo $record["character_name"] ?></P>
      <img src="<?php echo $record["save_path"] ?>" alt="PL" width="100" height="100">
      <?php }else{?>
        <P>登場キャラ:なし</P>
        <img src="asset\icon\free.png" alt="PL" width="100" height="100">
        <?php }?>
    </div>
  <?php endforeach; }?>
  </div>
</div>
<!---------------------------------------------------------------------------------------------------->
<div class="white_frame">
  <h1>シーン作成</h1>
  <p>これからシーンを作りましょう</p>
    <div class="straight_line">
      <!--form-->
      <form enctype="multipart/form-data" action="./upload_scene_set.php" method="POST">
        <h1>名前</h1>
        <div>
            シーンの名前: <input type="text" name="name">
        </div>
        <div> 
          <h1>イメージ</h1>
          <p>シーンののイメージ画像を入力してください</p>
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
          <h1>シーンの系統</h1>
          <div class="side_line">
            <select name="event_type">
              <option value="1" selected>演出(イベントの演出のみ行う、オープニングやエンディングに向いている)</option>
              <option value="2">戦闘(戦闘を行う、困難を退けて物語を進めよう)</option>
              <option value="3">探索(探索を行う、ゲームの導入と戦闘の間に行ってキャラクターを育てよう)</option>
            </select>
          </div>
          <div><input type="reset" value="リセットする"></div>
    <!---------------------------------------------------------------------------------------------------->
    <div>
      <?php foreach ($result as $record): ?>
      <div  class="side_line">
        <div>
          <?php //キャラクター表示
            /*echo "<img src='$record[save_path]' alt='logo' alt='$record[save_path]' width='100' height='100'>";
            echo '<br>';*/
            echo '<p>キャラクター名：'.$record["character_name"].'</p>';
            /*echo '<p>制作者：'.$record["character_name"].'</p>';*/
            echo '<br>';
            $pickup_character_id =$record["character_id"]
            ;?>
          <input type="hidden" name="$scenario_id" value="<?=$scenario_id?>">
          <input type="hidden" name="pickup_character_id" value="<?=$pickup_character_id?>">
          <input type="hidden" name="scenario_id" value="<?= $scenario_id?>">
          <div><button>このキャラクターにする</button></div>
        </div>
        
      </div>
      <?php endforeach; ?>
    </div>
    <!---------------------------------------------------------------------------------------------------->
    <!--ページネーションを表示-->
    <br>
    <div  class="side_line">
    <?php for ( $n = 1; $n <= $pages; $n ++){
            if ( $n == $now ){
                echo "<span style='padding: 5px;'>$now</span>";
            }else{
                echo "<a href='./maker_scenario_plus_scene.php?page_id=$n' style='padding: 5px;'>$n</a>";    
            }
        }
    ?>
    </div>
    <!---------------------------------------------------------------------------------------------------->
    </form>
  </div>
</dvi>
</div>
<?php include('set.php');?>
<?php
//検索システムの適用ページ
$list_character = 'maker_scenario_plus_scene.php';?>
<?php include('search.php');?>
</body>

</html>

