<!---------------------------------------------------------------------------------------------------->
<!-- menu -->
<div class="menu">
  <img src="asset/icon/favicon.vt.png" alt="logo" width='80' height='80'>
  <button class="skew-button" onclick="location.href = 'index.php'"><span>TOP</span></button>
  <button class="skew-button" onclick="location.href = 'play_scenario.php'"><span>遊ぶ</span></button>
  <button class="skew-button" onclick="location.href = 'list_scenario.php'"><span>シナリオ</span></button>
  <button class="skew-button" onclick="location.href = 'list_character.php'"><span>キャラクター</span></button>
  <button class="skew-button" onclick="location.href = 'list_item.php'"><span>アイテム</span></button>
  <button class="skew-button" onclick="location.href = 'vt_logout.php'"><span>ログアウト</span></button>
</div>
<!---------------------------------------------------------------------------------------------------->
<!-- message -->
<div class="message">
<div class="straight_line">
  <div class="box29">
    <div class="box-title"><?php echo $sessoin_message_title?></div>
      <!--メッセージ出力機構-->  
      <div class="straight_line">
        <p>
          <?php if($sessoin_message !== ''){
            echo $sessoin_message;
          }else{
            echo $random_message;    
          }?>
        </p>
      </div>
    </div>
    <img src="<?php echo $navigator?>" alt="<?php echo $navigator?>" width='200' height='200'>
  </div>
</div>
<!---------------------------------------------------------------------------------------------------->
<!-- message -->
<div class="pl_data">
<div class="straight_line">
  <div class="white_frame">
  <p>PL: <?php echo $user_name?></p>
  <div>
  <?php if(isset($play_character)){ ?>
  <?php foreach ($my_result as $record): ?>
    <img src="<?php echo $record["save_path"] ?>" alt="PL" width="100" height="100">
    <p>マイキャラクター:<?php echo $record["character_name"] ?></p>
    <?php endforeach; }else{?>
    <p>自分のキャラクターを選ぼう</p>
    <button onclick="location.href='list_character.php'">キャラを見る</button>
    <?php }?>
    </div>
    </div>
  </div>
</div>
<!---------------------------------------------------------------------------------------------------->  
<!-- message -->
<div class="vt_all_data">
  <div class ="white_frame">
    <h1>VisionsTale</h1>
    <div>
      <p>このゲームはプレーヤーが作ったキャラクターやアイテム、</P>
      <p>ゲームの舞台を作って、遊んで、シェアすることが出来ます。</P>
      <p>沢山作ってゲームの幅を広げましょう。</P>
      <p>現在このゲームに登場するキャラクター数:<?php echo $result_character_data_COUNT[0]["COUNT(*)"]?></P>
      <p>現在このゲームに登場するアイテム数:<?php echo $result_item_data_COUNT[0]["COUNT(*)"]?></P>
      <p>現在このゲームで遊べるシナリオ数:<?php echo $result_scenario_data_COUNT[0]["COUNT(*)"]?></P>
    </div>
  </div>
</div>
<!---------------------------------------------------------------------------------------------------->
