<br>
<br>
<!---------------------------------------------------------------------------------------------------->
<!-- message -->
<div>
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
<!-- My character -->
<div>
<div class="straight_line">
  <div class="white_frame_side">
  <p>PL: <?php echo $user_name?></p>
  <div>
  <?php if(isset($play_character)){ ?>
  <?php foreach ($my_result as $record): ?>
    <img src="<?php echo $record["save_path"] ?>" alt="PL" width="100" height="100">
    <p>マイキャラクター:<?php echo $record["character_name"] ?></p>
    <?php endforeach; }else{?>
    <p>自分のキャラクターを選ぼう</p>
    <button class="skew-button" onclick="location.href='list_character.php'">キャラを見る</button>
    <?php }?>
    </div>
    </div>
  </div>
</div>
<!---------------------------------------------------------------------------------------------------->  
