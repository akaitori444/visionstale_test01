<!---------------------------------------------------------------------------------------------------->
<!--検索機構-->
<div class="white_frame_side">
    <h1>ユーザーデータ絞り込み</h1>

    <p><?php echo $user_only_set?></P>
    <?php ?>
    <div>
    <form action="<?php echo $list_character?>" method="post">
        <input type="hidden" name="user_only_command" value=<?php echo $user_only_command?>>
        <button class="skew-button"><?php echo $user_only_set_button?></button>
    </form>
    <form action="<?php echo $list_character?>" method="post">
    <h1>順番</h1>
    <p>現在の並び:<?php echo $listorder?></P>
        <select name="order">
        <option value="1">ID順</option>
        <option value="2">ID逆順</option>
        <option value="3">あいうえお順</option>
        <option value="4">あいうえお逆順</option>
        <option value="5" selected>ランダム表示</option>
        </select><input type="submit">
    </form>
    <h1>検索</h1>
    <?php if(isset($search_term)){?>
    <p>検索ワード:<?php echo $search_term?></P>
    <?php }?>
    <div>
    <form action="<?php echo $list_character?>" method="post">
            Name:<input type="text" name="search_term"><input type="submit">
            <input type="hidden" name="search_out" value="false">
            <input type="hidden" name="order" value="1">
    </form>
    <form action="<?php echo $list_character?>" method="post">
            <input type="hidden" name="search_out" value="true">
            <input type="hidden" name="order" value="1">
            <p>検索解除<input type="submit"></p>
    </form>
    </div>
</div>
<!---------------------------------------------------------------------------------------------------->