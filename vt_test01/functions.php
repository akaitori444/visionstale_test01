<?php
/*---------------------------------------------------------------------------*/
/**
 * @author 僕話ヒノトリ red5brack5@gmail.com
 * @copyright 僕話ヒノトリ
 * @version 1.0.0
 */
/*-------------------------------------------------------------------------------*/
/**
 * DB接続用
 * @return 指定のデータベースへ接続
 */
/*-------------------------------------------------------------------------------*/
//serverDB接続用
function connect_vt_db()
{
  $host = "mysql57.bokuwa.sakura.ne.jp";
  $dbName = "bokuwa_game_visions";
  $user = 'bokuwa';
  $password = 'bokuwa_444';
  $dsn = "mysql:host={$host};dbname={$dbName};charser=utf8";
  
  try {
    return new PDO($dsn, $user, $password);
  } catch (PDOException $e) {
    echo json_encode(["db error" => "{$e->getMessage()}"]);
    exit();
  }
}
/*-------------------------------------------------------------------------------*/
/**
 * タグセーブ用
 * @param string $tag_name タグ名
 * @return 既存のタグを検索して被りがなければ登録
 */
/*-------------------------------------------------------------------------------*/
function fileSavetag($tag_name)
{
    $pdo = connect_vt_db();
    $sql = "INSERT INTO tag (tag_name) VALUES (?)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $tag_name);

    try {
        $status = $stmt->execute();
    } catch (PDOException $e) {
        echo json_encode(["sql error" => "{$e->getMessage()}"]);
        exit();
    }
}
/*-------------------------------------------------------------------------------*/
/**
 * ランダムな半角英数字の作成
 * @param int $length 文字数
 * @return $lengthと同じ数の半角英数字の文字列
 */
/*-------------------------------------------------------------------------------*/
function generateRandomString($length) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
  $result = '';
  for ($i = 0; $i < $length; $i++) {
      $result .= $characters[rand(0, strlen($characters) - 1)];
  }
  return $result;
}
/*-------------------------------------------------------------------------------*/
/**
 * ログイン状態のチェック関数
 * @return バリデーションに異常があればエラーメッセージを検出する
 */
/*-------------------------------------------------------------------------------*/
function check_session_id()
{
  if (!isset($_SESSION["session_id"]) ||$_SESSION["session_id"] !== session_id()) {
    header('Location:vt_login.php');
    exit();
  } else {
    session_regenerate_id(true);
    $_SESSION["session_id"] = session_id();
  }
}
/*---------------------------------------------------------------------------*/
/**
 * 画像、キャプションファイルのバリデーション
 * @param string $introduction キャプション(説明)
 * @param int $filesize ファイルのサイズ
 * @param string $file_err ファイルエラー
 * @param string $filename ファイル形式判別用ファイル名
 * @return バリデーションに異常があればエラーメッセージを検出する
 */
/*---------------------------------------------------------------------------*/
function filevalidation($introduction, $filesize ,$file_err ,$filename){
  $err_msgs = array();
  // キャプションのバリデーション
  //未入力
  if(empty($introduction)){
    array_push($err_msgs,  'キャプションを入力してください。');
    echo '<br>';
  }
  //140文字か？
  if(strlen($introduction) > 120){
    array_push($err_msgs,  'キャプションは120文字以内で入力してください。');
    echo '<br>';
  }
  //ファイルサイズが1MB未満か
  if($filesize > 1048576 || $file_err == 2){
  array_push($err_msgs,  'ファイルサイズは1MB未満にしてください。');
  echo '<br>';
  }
  //拡張は画像形式か
  $allow_ext = array('jpg', 'jpeg', 'png');
  $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
  if (!in_array(strtolower($file_ext), $allow_ext)){
  array_push($err_msgs,  '画像ファイルを添付してください。');
  echo '<br>';
  }
  return $err_msgs;
}
/*---------------------------------------------------------------------------*/
/**
 * 検索機構
 * @param string $list_name 検索対象のカラム
 * @param string $search_id ID検索用テーブルのID名
 * @param string $search_name ID検索用テーブルの名前
 * @param int $_GET['page_id'] 現在のページ番号を$_GET['page_id']で取得
 * @param string $_POST['search_term'] 現在の検索ワードを$_POST[search_term']で取得
 * @return 検索結果に応じたリスト
 */
/*---------------------------------------------------------------------------*/
function searchandorder($list_name, $search_id, $search_name){
  $sql_base = "SELECT * FROM $list_name";
  if(@$_POST["order"] != ""){
    unset($_SESSION["order"]);
    if($_POST["order"] == 1){
      $db_order = " ORDER BY $search_id DESC";
      $listorder = 'ID順';
    }elseif($_POST["order"] == 2){
      $db_order = " ORDER BY $search_id ASC";
      $listorder = 'ID逆順';
    }elseif($_POST["order"] == 3){
      $db_order = " ORDER BY $search_name DESC";
      $listorder = 'あいうえお順';
    }elseif($_POST["order"] == 4){
      $db_order = " ORDER BY $search_name ASC";
      $listorder = 'あいうえお逆順';
    }elseif($_POST["order"] == 5){
      $db_order = ' ORDER BY RAND()';
      $listorder = 'ランダム表示';
    }
    $_SESSION["order"] = $_POST["order"];
  }else{
    if(@$_SESSION["order"] != ""){
      if($_SESSION["order"] == 1){
        $db_order = " ORDER BY $search_id DESC";
        $listorder = 'ID順';
      }elseif($_SESSION["order"] == 2){
        $db_order = " ORDER BY $search_id ASC";
        $listorder = 'ID逆順';
      }elseif($_SESSION["order"] == 3){
        $db_order = " ORDER BY $search_name DESC";
        $listorder = 'あいうえお順';
      }elseif($_SESSION["order"] == 4){
        $db_order = " ORDER BY $search_name ASC";
        $listorder = 'あいうえお逆順';
      }elseif($_SESSION["order"] == 5){
        $db_order = ' ORDER BY RAND()';
        $listorder = 'ランダム表示';
      }
    }else{
      $db_order = ' ORDER BY RAND()';
      $listorder = 'ランダム表示';    
    }
  }
  //save_pathの入力有無を確認
  if(@$_POST["search_term"] != ""){ 
    unset($_SESSION["search_term"]);
    $search_term = $_POST["search_term"];
    $db_search = " WHERE $search_name like '$search_term'"; //SQL文を実行して、結果を$stmtに代入する。
    $_SESSION["search_term"] = $_POST["search_term"];
  }else{
    if(@$_POST["search_out"] = true){ 
      unset($_SESSION["search_term"]);
      $search_term = '';
      $db_search = '';
    }else{
      if(@$_POST["search_out"] = false || @$_SESSION["search_term"] != ""){ 
        $search_term = $_SESSION["search_term"];
        $db_search = " WHERE $search_name like '$search_term'"; //SQL文を実行して、結果を$stmtに代入する。
      }else{
      $search_term = '';
      $db_search = '';
      }

    }
  }
  //DB接続
  $pdo = connect_vt_db();
  //1ページに表示する記事の数をmax_viewに定数として定義
  define('max_view',4);
  //必要なページ数を求める
  $list_set = "SELECT COUNT(*) AS count FROM $list_name";
  $list_page = $list_set.$db_search;
  $count = $pdo->prepare($list_page);
  $count->execute();
  $total_count = $count->fetch(PDO::FETCH_ASSOC);
  $pages = ceil($total_count['count'] / max_view);
  $db_limit = " LIMIT :start,:max";
  
  //現在いるページのページ番号を取得
  if(!isset($_GET['page_id'])){ 
    $now = 1;
  }else{
    $now = $_GET['page_id'];
  }
  $sql = $sql_base.$db_search.$db_order.$db_limit;
  //表示する記事を取得するSQLを準備
  $stmt = $pdo->prepare($sql);  
  if ($now == 1){
  //1ページ目の処理
  $stmt->bindValue(":start",$now -1,PDO::PARAM_INT);
  $stmt->bindValue(":max",max_view,PDO::PARAM_INT);
  } else {
  //1ページ目以外の処理
  $stmt->bindValue(":start",($now -1)*max_view,PDO::PARAM_INT);
  $stmt->bindValue(":max",max_view,PDO::PARAM_INT);
  }
  try {
    $status = $stmt->execute();
  } catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
  }
  // SQL作成&実行
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return array($result, $search_term, $listorder ,$pages ,$now);
}
/*-------------------------------------------------------------------------------*/
/**
 * ランダムメッセージ
 * @return ランダムなメッセージ内容
 */
/*-------------------------------------------------------------------------------*/
function Randommessage(){
  $number = rand(0, 9);
  $message = array(
    0 => "あなたは大海賊です。"."<br>"."あなたの船を操り、海賊王になるために他の船を襲撃しましょう！",
    1 => "今日は魔法使いになる日。"."<br>"."あなたの魔法の杖を手に入れて、魔法界を冒険しましょう！",
    2 => "あなたは強力なドラゴン討伐者です。"."<br>"."今日はどのドラゴンを狙いますか？",
    3 => "あなたは宇宙の最後の生き残りです。"."<br>"."あなたの使命は、地球に生命を再びもたらすことです！",
    4 => "あなたは幻想的な世界に迷い込んでしまいました。"."<br>"."怪物に遭遇しないように、あなたの冒険を始めましょう！",
    5 => "あなたは有名な探検家です。"."<br>"."今日はあなたの名前を残すために、未知の土地を探検しましょう！",
    6 => "あなたはお金持ちの冒険家です。"."<br>"."宝石や財宝を探し出し、あなたの財産を増やしましょう！",
    7 => "あなたは忍者の一員です。"."<br>"."あなたの任務は、暗殺を実行し、敵を倒すことです！",
    8 => "あなたは魔女の弟子です。"."<br>"."あなたの使命は、魔法の力を学び、世界を救うことです！",
    9 => "あなたは古代の勇者です。"."<br>"."あなたの伝説を継承するために、伝説のアイテムを探し出しましょう！"
  ); 
  $result = $message[$number];
  return $result;
}
/*---------------------------------------------------------------------------*/
/**
 * 前後ページへのリンク表示
 * @param int $totalPage 最大ページ数
 * @param int $page 現在のページ番号
 */
/*---------------------------------------------------------------------------*/
function paging($totalPage, $page = 1){
  $page = (int) htmlspecialchars($page);

  $prev = max($page - 1, 1); // 前のページ番号
  $next = min($page + 1, $totalPage); // 次のページ番号

  if ($page != 1) { // 最初のページ以外で「前へ」を表示
    print '<a href="?page=' . $prev . '">&laquo; 前へ</a>';
  }
  if ($page < $totalPage){ // 最後のページ以外で「次へ」を表示
    print '<a href="?page=' . $next . '">次へ &raquo;</a>';
  }

  /*確認用*/
  /*
  print "<pre>current:".$page."\n";
  print "next:".$next."\n";
  print "prev:".$prev."</pre>";
  */
}
/*---------------------------------------------------------------------------*/
/**
 * ページ番号リンクの表示
 * @param int $totalPage データの最大件数
 * @param int $page 現在のページ番号
 * @param int $pageRange $pageから前後何件のページ番号を表示するか
 */
/*---------------------------------------------------------------------------*/
function paging2($totalPage, $page = 1, $pageRange = 2){
    
  // ページ番号
  $page = (int) htmlspecialchars($page);
  // 前ページと次ページの番号計算
  $prev = max($page - 1, 1);
  $next = min($page + 1, $totalPage);
  $nums = []; // ページ番号格納用
  $start = max($page - $pageRange, 2); // ページ番号始点
  $end = min($page + $pageRange, $totalPage - 1); // ページ番号終点
  if ($page === 1) { // １ページ目の場合
    $end = $pageRange * 2; // 終点再計算
  }
  // ページ番号格納
  for ($i = $start; $i <= $end; $i++) {
    $nums[] = $i;
  }
  //最初のページへのリンク
  if ($page > 1 && $page !== 1){
  	print '<a href="?page=1" title="最初のページへ">« 最初へ</a>';
  } else {
    print '<span>« 最初へ</span>';
  }
  // 前のページへのリンク
  if ($page > 1) {
    print '<a href="?page=1" title="前のページへ">&laquo; 前へ</a>';
  } else {
    print '<span>&laquo; 前へ</span>';
  }
  // 最初のページ番号へのリンク
  print '<a href="?page=1">1</a>';
  if ($start > $pageRange) print "..."; // ドットの表示	
  //ページリンク表示ループ
  foreach ($nums as $num) {
    // 現在地
    if ($num === $page) {
      print '<span class="current">' . $num . '</span>';
    } else {
      // ページ番号リンク表示
      print '<a href="?page='. $num .'" class="num">' . $num . '</a>';
    }
  }
  if (($totalPage - 1) > $end ) print "...";	//ドットの表示
  //最後のページ番号へのリンク
  if ($page < $totalPage) {
	  print '<a href="?page='. $totalPage .'">' . $totalPage . '</a>';
  } else {
    print '<span>' . $totalPage . '</span>';
  }
  // 次のページへのリンク
  if ($page < $totalPage){
    print '<a href="?page='.$next.'">次へ &raquo;</a>';
  } else {
    print '<span>次へ &raquo;</span>';
  }
  //最後のページへのリンク
  if ($page < $totalPage){
  	print '<a href="?page=' . $totalPage . ' title="最後のページへへ">最後へ »</a>';
  } else {
    print '<span>最後へ »</span>';
  }
  // 確認用
  /*
  print "<pre>current:".$page."\n";
  print "next:".$next."\n";
  print "prev:".$prev."\n";
  print "start:".$start."\n";
  print "end:".$end."</pre>";
  */
}
/*---------------------------------------------------------------------------*/
?>