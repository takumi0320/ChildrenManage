<nav class="drawer-nav">
    <ul class="drawer-menu">
        <!-- ドロワーメニューの中身 -->
        <h1 class="drawer-header">mamoriOメニュー</h1>
        <div class="drawer-list">
            <li class="drawer-contents drawer-contents-first">
                <a href="./ChildSelect.php">
                    <?php
                    echo $_SESSION['ChildName'];
                    ?>
                </a>
            </li>
            <li class="drawer-contents"><a href="./index.php">ホーム</a></li>
            <li class="drawer-contents"><a href="./statistics.php">統計を見る</a></li>
            <li class="drawer-contents"><a href="./now.php">いまどうしてる？</a></li>
            <li class="drawer-contents"><a href="./config.php">設定</a></li>
            <li class="drawer-contents drawer-contents-last"><a href="./logout.php">ログアウト</a></li>
        </div>
    </ul>
</nav>