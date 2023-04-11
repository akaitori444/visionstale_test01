<?php include('login_set.php'); 
/*セッション開始、ログインチェック、function読み込み、DBチェック、セッション定義*/ ?>
<?php
//ファイル関連の取得
$file = $_FILES['img'];
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
$upload_dir = 'images/character/';
$save_pass_set = date('YmdHis').$filename_tuning;
$save_filename = $save_pass_set.'.png';
$save_path = $upload_dir.$save_filename;
//名前
$name = $_POST["name"];
//キャプション
$introduction = filter_input(INPUT_POST,'caption',
FILTER_SANITIZE_SPECIAL_CHARS);
/*---------------------------------------------------------------------------*/
//個別データ
//戦闘傾向
$battle_style = $_POST["battle_style"];
//スペック
$attack = $_POST["attack"];
$toughness = $_POST["toughness"];
$speed = $_POST["speed"];
$technic = $_POST["technic"];
$imagination = $_POST["imagination"];
$chase = $_POST["chase"];
/*---------------------------------------------------------------------------*/
// バリデーション
$err_msgs = filevalidation($introduction, $filesize ,$file_err ,$filename);
/*---------------------------------------------------------------------------*/
//サーバー＆DBアップロード機構
/*---------------------------------------------------------------------------*/
if(count($err_msgs) === 0){//エラーチェック
    /*---------------------------------------------------------------------------*/
    //画像データの保存
    /*---------------------------------------------------------------------------*/
    if(is_uploaded_file($tmp_path)){//ファイルはあるかどうか？
        if(move_uploaded_file($tmp_path, $save_path)){//$save_pathのファイルを$tmp_pathへ保存
            //保存成功時
            echo $filename . 'を'. $upload_dir.'にアップしました。';
        }else{
            //保存失敗時
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
    //character_main_dataの作成
    /*---------------------------------------------------------------------------*/
    try {
        // テーブルにデータを送信する
        $stmt = $pdo->prepare('INSERT INTO character_main_data (creater_id, character_id, character_name, save_path) VALUES (?, ?, ?, ?)');
        $stmt->execute([$user_id, $save_pass_set, $name, $save_path]);
        // トランザクションをコミットする
        $pdo->commit();
        echo 'データを送信しました。';
        } catch (PDOException $e) {// エラー発生時
        // トランザクションをロールバックする
        $pdo->rollback(); 
        echo json_encode(["db error" => "{$e->getMessage()}"]);
        exit();
        }
    }else{
        array_push($err_msgs,  'ファイルが選択されていません。');
        echo '<br>';
    }
    /*---------------------------------------------------------------------------*/
    //直前のmain_idを取得する
    /*---------------------------------------------------------------------------*/
    //DB接続
    $pdo = connect_vt_db();
    $sql_set = "SELECT * FROM character_main_data WHERE save_path = '$save_path'";
    $stmt_set = $pdo->prepare($sql_set);
    try {
        $status_set = $stmt_set->execute();
    } catch (PDOException $e) {
        echo json_encode(["sql error" => "{$e->getMessage()}"]);
        exit();
    }
    // SQL作成&実行
    $result = $stmt_set->fetchAll(PDO::FETCH_ASSOC);
    $set_id = $result[0]["main_id"];
    $character_id = $save_pass_set.$set_id;
    /*---------------------------------------------------------------------------*/
    //DBへの保存
    /*---------------------------------------------------------------------------*/
    //DB接続
    $pdo = connect_vt_db();
    // トランザクションを開始する
    $pdo->beginTransaction();
    /*---------------------------------------------------------------------------*/
    //character_main_dataの作成
    /*---------------------------------------------------------------------------*/
    try {

        //1.character_game_data
        $stmt1 = $pdo->prepare('INSERT INTO character_game_data (creater_id, character_id, character_name, save_path, battle_style) VALUES (?, ?, ?, ?, ?)');
        $stmt1->execute([$user_id, $character_id, $name, $save_path, $battle_style]);
        
        //2.character_spec_set
        $stmt2 = $pdo->prepare('INSERT INTO character_spec_set (character_spec_id, attack, toughness, speed, technic, imagination, chase) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt2->execute([$character_id, $attack, $toughness, $speed, $technic, $imagination, $chase]);

        //3.character_profile_data
        $stmt3 = $pdo->prepare('INSERT INTO character_profile_data (character_id, introduction) VALUES (?, ?)');
        $stmt3->execute([$character_id, $introduction_br]);
        
        // トランザクションをコミットする
        $pdo->commit();
    /*---------------------------------------------------------------------------*/
        //$alert = "<script type='text/javascript'>alert('データを送信しました。');</script>";
        //echo $alert;
        //echo 'データを送信しました。';
        $_SESSION['output_message_type'] == 2;//成功メッセージ
        $_SESSION['output_message'] = "'$name'のキャラクターデータを作成しました";
    /*---------------------------------------------------------------------------*/

        
    } catch (PDOException $e) {
        // トランザクションをロールバックする
        $pdo->rollback(); 
        echo json_encode(["db error" => "{$e->getMessage()}"]);
        exit();
    }
    /*---------------------------------------------------------------------------*/
} else {
    foreach($err_msgs as $masg){
        $_SESSION['output_message_type'] == 1;//エラーメッセージ
        $_SESSION['output_message'] = json_encode(["db error" => "{$e->getMessage()}"]);
    }
}

// 処理後にページを移動
header("location: maker_character.php");

?>

<a href="./maker_character.php">戻る</a>