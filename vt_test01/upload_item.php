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
$upload_dir = 'images/item/';
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
$type = $_POST['type']; 
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
            //1.item_data
            $stmt1 = $pdo->prepare('INSERT INTO item_data (item_name, item_image, item_introduction, item_type) VALUES (?, ?, ?, ?)');
            $stmt1->execute([$name, $save_path, $introduction_br, $type]);
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

header("location: maker_item.php");
?>

<a href="./maker_item.php">戻る</a>
