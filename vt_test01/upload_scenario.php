<?php include('login_set.php'); 
/*セッション開始、ログインチェック、function読み込み、DBチェック、セッション定義*/ ?>
<?php
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
//個別データ
//アイテムタイプ
//$type = $_POST['type']; 
//シナリオの傾向
//$mission = $_POST['mission'];
//$clearmission = $_POST['clearmission'];
//$clearbonus = $_POST['clearbonus'];
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
    //scenario_dataの作成
    /*---------------------------------------------------------------------------*/
        try {
            //1.scenario_dataにデータを送信する
            $stmt1 = $pdo->prepare('INSERT INTO scenario_data (creater_name, scenario_id, scenario_name, scenario_image, scenario_introduction) VALUES (?, ?, ?, ?, ?)');
            $stmt1->execute([$user_name, $save_pass_set, $name, $save_path, $introduction_br]);
            // トランザクションをコミットする
            $pdo->commit();

            $alert = "<script type='text/javascript'>alert('データを送信しました。');</script>";
            echo $alert;
            //echo 'データを送信しました。';    
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
    }
}else {
    foreach($err_msgs as $masg){
        $alert = "<script type='text/javascript'>alert('". $masg. "');</script>";
        echo $alert;
        echo '<br>';
    }
}

// 処理後にページを移動

header("location: maker_scenario.php");
?>

<a href="./list_scenario.php">戻る</a>