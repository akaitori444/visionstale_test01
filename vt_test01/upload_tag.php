<?php include('login_set.php'); 
/*セッション開始、ログインチェック、function読み込み、DBチェック、セッション定義*/ ?>
<?php
//エラーメッセージの取得
$err_msgs = array();
//タグ名の取得
$tag_name = $_POST["tag_name"];
/*---------------------------------------------------------------------------*/
//バリデーション
//入力の確認
if(empty($tag_name)){
    array_push($err_msgs,  'タグを入力してください。');
    echo '<br>';
}
//6文字以内か？
if(strlen($tag_name) > 18){
    array_push($err_msgs,  'タグは6文字以内で入力してください。');
    echo '<br>';
}
// データベース内に同じ名前が存在するか確認する
$stmt = $pdo->prepare('SELECT COUNT(*) FROM tag WHERE tag_name = :tag_name');
$stmt->bindParam(':tag_name', $tag_name);
$stmt->execute();
$count = $stmt->fetchColumn();
/*---------------------------------------------------------------------------*/
//入力
if ($count == 0) {
  // データベースに挿入する
  $stmt = $pdo->prepare('INSERT INTO tag (tag_name) VALUES (:tag_name)');
  $stmt->bindParam(':tag_name', $tag_name);
  $stmt->execute();
  echo $tag_name . 'をタグとして登録しました。';
} else {
  // 名前がすでに存在する場合の処理
  echo 'その名前はすでに存在します';
}
/*---------------------------------------------------------------------------*/
?>

<a href="./maker_tag.php">戻る</a>
