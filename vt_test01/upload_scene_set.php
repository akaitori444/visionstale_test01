<?php include('login_set.php'); 
/*セッション開始、ログインチェック、function読み込み、DBチェック、セッション定義*/ ?>
<?php
//0.連携シーン読み込み
/*---------------------------------------------------------------------------*/
$scenario_id = $_POST["scenario_id"];
//sceneの順番変更、検索機構
$sql = "SELECT * FROM scenario_data LEFT OUTER JOIN scene_set ON scenario_id = scenario_connect WHERE scenario_id = '$scenario_id'";
$stmt = $pdo->prepare($sql);
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
// SQL作成&実行
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
if($result[0]["id"] != NULL){
  $order_number = count($result);  
}else{
  $order_number = 0;
}
/*---------------------------------------------------------------------------*/
/*
//確認用
echo('<pre>');
echo var_dump($_POST);
//echo var_dump($result2);
exit();
/*---------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------*/
//ファイル関連の取得
$file = $_FILES['img'];
/*---------------------------------------------------------------------------*/
// 画像データパスを用意する
$filename = basename($file['name']);
/*---------------------------------------------------------------------------*/
// データの定義
/*---------------------------------------------------------------------------*/
//共有データ
//エラーチェック用
$tmp_path = $file['tmp_name'];
$file_err = $file['error'];
$filesize = $file['size'];
//画像データの定義
$filename = basename($file['name']);
$filename_tuning = generateRandomString(8);
$upload_dir = 'images/scenario/';
$save_pass_set = date('YmdHis').$filename_tuning;
$save_filename = $save_pass_set.'.png';
$save_path = $upload_dir.$save_filename;
//名前
$name = $_POST["name"];
//キャプション
$introduction = filter_input(INPUT_POST,'caption',
FILTER_SANITIZE_SPECIAL_CHARS);
/*---------------------------------------------------------------------------*/
//シーン
$scene_event_type = $_POST['event_type'];
$character_id = $_POST["pickup_character_id"];

/*---------------------------------------------------------------------------*/
// バリデーション
$err_msgs = filevalidation($introduction, $filesize ,$file_err ,$filename);
/*---------------------------------------------------------------------------*/

if(count($err_msgs) === 0){
    //ファイルはあるかどうか？
    if(is_uploaded_file($tmp_path)){
        if(move_uploaded_file($tmp_path, $save_path)){
            echo $filename . 'を'. $upload_dir.'にアップしました。';
        }else{
            array_push($err_msgs,  'ファイルが保存できませんでした。');
        }
      /*---------------------------------------------------------------------------*/
      //DBへの保存
      /*---------------------------------------------------------------------------*/
      //DB接続
      $pdo = connect_vt_db();
      // トランザクションを開始する
      $pdo->beginTransaction();
      /*---------------------------------------------------------------------------*/
      //キャプションの改行処理
      /*---------------------------------------------------------------------------*/
      $introduction_br = nl2br($introduction);
      /*---------------------------------------------------------------------------*/
      try {
          // テーブル1にデータを送信する
          $stmt1 = $pdo->prepare('INSERT INTO scene (scene_name, scene_image, scene_introduction, scene_event_type, actor_set_connect) VALUES (?, ?, ?, ?, ?)');
          $stmt1->execute([$name, $save_path, $introduction_br, $scene_event_type, $character_id]);
          // トランザクションをコミットする
          $pdo->commit();
          
          echo 'シーンデータを送信しました。';
      } catch (PDOException $e) {
          // トランザクションをロールバックする
          $pdo->rollback(); 
          echo json_encode(["db error" => "{$e->getMessage()}"]);
          exit();
      }
      /*---------------------------------------------------------------------------*/
      //直前のscene_idを取得する
      /*---------------------------------------------------------------------------*/
      $sql2 = "SELECT * FROM scene WHERE scene_id = LAST_INSERT_ID();";
      $stmt2 = $pdo->prepare($sql2);
      try {
        $status2 = $stmt2->execute();
      } catch (PDOException $e) {
        echo json_encode(["sql error" => "{$e->getMessage()}"]);
        exit();
      }
      // SQL作成&実行
      $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
      $scene_id = $result2[0]["scene_id"];
      /*---------------------------------------------------------------------------*/
      //scene_setを入力する
      /*---------------------------------------------------------------------------*/
      $pdo->beginTransaction();
      try {
          // テーブル3にデータを送信する
          $stmt3 = $pdo->prepare('INSERT INTO scene_set (scenario_connect, scene_connect, order_number) VALUES (?, ?, ?)');
          $stmt3->execute([$scenario_id, $scene_id, $order_number]);
          // トランザクションをコミットする
          $pdo->commit();
          
          echo 'シーンセットデータを送信しました。';
      } catch (PDOException $e) {
          // トランザクションをロールバックする
          $pdo->rollback(); 
          echo json_encode(["db error" => "{$e->getMessage()}"]);
          exit();
      }
      /*---------------------------------------------------------------------------*/
  }else{
      array_push($err_msgs,  'ファイルが選択されていません。');
      echo '<br>';
}} else {
    foreach($err_msgs as $masg){
        echo $masg;
        echo '<br>';
    }
}
$_SESSION["pickup_scenario_id"] = $scenario_id;
header("location: maker_scenario_plus_scene.php");

?>
<form enctype="multipart/form-data" action="./maker_scenario_plus_scene.php" method="POST">
  <input type="hidden" name="scenario_id" value="<?=$scenario_id?>">
  <button >シーン作成に戻る</button>
</form>

