<?php include('login_set.php'); 
/*セッション開始、ログインチェック、function読み込み、DBチェック、セッション定義*/ ?>
<?php
/*---------------------------------------------------------------------------*/
$sql = 'SELECT * FROM scene';
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
//シナリオデータ取得
$scenario_id = $_POST["scenario_id"];
$stmt1 = $pdo->query("SELECT * FROM scenario_data WHERE scene_set_connect like '%{$scenario_id}%'");

try {
  $status1 = $stmt1->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
// SQL作成&実行
$result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
/*---------------------------------------------------------------------------*/
// データを取得してIDが存在するかどうかを確認する
$connect = $_POST["scene_set_connect"];
$sql = "SELECT COUNT(*) FROM scene_set WHERE scene_connect = :connect";
$stmt3 = $pdo->prepare($sql);
$stmt3->bindParam(':connect', $connect, PDO::PARAM_STR);
$stmt3->execute();
$count = $stmt3->fetchColumn();

// 結果を表示する
if ($count > 0) {
    echo "ID {$connect} は存在します。";
    //シーンコネクト取得
    $scene_set_connect = $_POST["scene_set_connect"];
    $stmt2 = $pdo->query("SELECT * FROM scene_set WHERE scene_connect like '%{$scene_set_connect}%'");

    try {
      $status2 = $stmt2->execute();
    } catch (PDOException $e) {
      echo json_encode(["sql error" => "{$e->getMessage()}"]);
      exit();
    }
    // SQL作成&実行
    $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
  } else {
    echo "ID {$connect} は存在しません。";
}
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
  <dvi>
    <div><!-- メニュー -->
      <div>
        <button onclick="location.href='index.php'">メニューに戻る</button>
      </div>
      <div>
        <button onclick="location.href='maker_menu.php'">作成メニューに戻る</button>
      </div>
    </div>
      <h1>シナリオ作成</h1>
      <p>シーンを繋げてシナリオを作りましょう</p>
      <div class='side_line'>
        <!-------------------------------------------------------------------------------------------------------------------------------->
        <div>
          <div class='straight_line'><!-- リストから選択 -->
          <h1>登録シーン</h1>
          <table>
            <thead>
              <tr>
                <th>シーン名</th>
                <th>イメージ</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($result1 as $record): ?>
                <tr>
                <td class='straight_line'><?php echo $record["scenario_name"] ?></td>
                <td><img src="<?php echo $record["save_path"] ?>" alt="save_path" width="150" height="100"></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          </div>
        </div>
        <!-------------------------------------------------------------------------------------------------------------------------------->
        <div class='straight_line'><!-- リストから選択 -->
              <h1>登録したシーン</h1>
              <table>
                <thead>
                  <tr>
                    <th>登録順</th>
                    <th>シーン名</th>
                    <th>イメージ</th>
                  </tr>
                </thead>
                <tbody>
                <?php if ($count > 0) {foreach ($result2 as $record): ?>
                  <?php foreach ($result as $student) {
                        if ($student['id'] === $record["scene_connect"]) {
                            $scene_name1 = $student['scene_name'];
                            $save_path = $student['scene_image'];
                            break;
                        }
                    }
                    ?>
                    <tr>
                    <td><?php echo $record["order_number"] ?></td>
                    <td><?php echo $scene_name1 ?></td>
                    <td><img src="<?php echo $save_path ?>" alt="scene_image" width="150" height="100"></td>
                    </tr>
                  <?php endforeach; }?>
                </tbody>
              </table>
            </div>
        <!-------------------------------------------------------------------------------------------------------------------------------->
        <div>
          <form enctype="multipart/form-data" action="./upload_scene_set.php" method="POST">
            <div class='straight_line'><!-- リストから選択 -->
              <h1>シーン選択</h1>
              <table>
                <thead>
                  <tr>
                    <th>シーン名</th>
                    <th>イメージ</th>
                    <th>選ぶ</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($result as $record): ?>
                    <tr>
                    <td class='straight_line'><?php echo $record["scene_name"] ?></td>
                    <td><img src="<?php echo $record["scene_image"] ?>" alt="scene_image" width="150" height="100"></td>
                    <?php $id = $record["id"]?>
                    <input type="hidden" name="scene_id" value="<?=$id?>">
                    <input type="hidden" name="scenario_id" value="<?=$scenario_id?>">
                    <input type="hidden" name="scene_set_connect" value="<?=$scene_set_connect?>">
                    <td><button>追加する</button></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </form>
        </div>
      </div>
        <div class='straight_line'><!-- 作成 -->
              <div>
                <button onclick="location.href='maker_menu.php'">完成させる</button>
              </div>
        </div>
  </dvi>
<?php include('set.php');?>
</body>

</html>

