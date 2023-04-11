<br>
<br>

<!-- message -->
<div>
  <div class ="white_frame_side">
  <pre>
  user_only:<?php echo var_dump($_SESSION['user_only']) ?>
  sql_check:<?php echo var_dump($sql_check) ?>
  user_id:<?php echo var_dump($_SESSION['id']) ?>
<!-- 
    <h1>VisionsTale</h1>
    <div>
      <p>このゲームはプレーヤーが作ったキャラクターやアイテム、</P>
      <p>ゲームの舞台を作って、遊んで、シェアすることが出来ます。</P>
      <p>沢山作ってゲームの幅を広げましょう。</P>
      <p>現在このゲームに登場するキャラクター数:<?php echo $result_character_data_COUNT[0]["COUNT(*)"]?></P>
      <p>現在このゲームに登場するアイテム数:<?php echo $result_item_data_COUNT[0]["COUNT(*)"]?></P>
      <p>現在このゲームで遊べるシナリオ数:<?php echo $result_scenario_data_COUNT[0]["COUNT(*)"]?></P>
    </div>
-->
    <button class="skew-button" onclick="location.href = 'vt_logout.php'">ログアウト</button>


  </div>
</div>
<!---------------------------------------------------------------------------------------------------->
