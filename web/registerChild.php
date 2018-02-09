<?php
include '../include/login_check.php';
if(isset($_POST['childName']) && $_POST['gender']){
    require_once '../DB/UserManager.php';
    $UM = new UserManager();
    $parentID = $_SESSION['ParentID'];
    $childName = htmlspecialchars($_POST['childName'] , ENT_QUOTES, 'UTF-8');
    $gender = htmlspecialchars($_POST['gender'], ENT_QUOTES, 'UTF-8');
    $childName = $childName . $gender;
    $UM->registerChild($parentID, $childName);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>子供登録 | mamoriO</title>
    <link rel="shortcut icon" href="../favicon/favicon.ico" type="image/vnd.microsoft.ico">
    <link rel="apple-touch-icon-precomposed" href="../favicon/favicon-152.png">
    <!-- Bootstrap CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/smoke.min.css" rel="stylesheet">
    <link href="../css/glyphicon.css" rel="stylesheet">
    <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.4.min.js"></script>
    <script src="../js/tether.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/smoke.min.js"></script>
    <script src="../lang/ja.min.js"></script>
    <link rel="stylesheet" href="../css/main_style.css">
    <link rel="stylesheet" href="../css/form_style.css">
    <link rel="stylesheet" href="../css/smoke_change.css">
</head>
<body>
    <div id="header">
        <div id="header-name">mamoriO</div>
    </div>
    <div id="head-blank"></div>
    <div class="card-field">

        <div class="card">
            <div class="card-block">
                <h4 class="card-title txt-title">子供登録</h4>
                <form id="formEmpty" data-smk-icon="glyphicon-remove-sign" action="./registerChild.php" method="post">
                    <div class="form-group">
                        <label class="control-label">お子さんの名前</label>
                        <input type="text" class="form-control" name="childName" placeholder="お子さんの名前" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label">お子さんの性別</label>
                        <label class="custom-control custom-radio">
                          <input id="radio1" name="gender" value="くん" type="radio" class="custom-control-input" checked>
                          <span class="custom-control-indicator color-boy"></span>
                          <span class="custom-control-description">男の子</span>
                      </label>
                      <label class="custom-control custom-radio">
                          <input id="radio2" name="gender" value="ちゃん" type="radio" class="custom-control-input">
                          <span class="custom-control-indicator color-girl"></span>
                          <span class="custom-control-description">女の子</span>
                      </label>
                  </div>

                  <div class="button-grp">
                      <button type="button" id="btnEmpty" class="btn btn-warning" name="login">登録</button>
                      <button type="button" class="btn btn-warning" onClick="history.back();">戻る</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
  <script>
    $(document).ready(function(){
        $('#btnEmpty').on('click',function(e) {
            if ($('#formEmpty').smkValidate()) {
                var target = document.getElementById("formEmpty");
                target.method = "post";
                target.submit();
            }
        });
    });
</script>
</body>
</html>
