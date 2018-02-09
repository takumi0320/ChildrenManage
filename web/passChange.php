<?php
include '../include/login_check.php';
if(isset($_POST['pass']) && isset($_POST['chpass1'])){
    require_once '../DB/UserManager.php';
    $UM = new UserManager();
    $parentID = htmlspecialchars($_SESSION['ParentID'] , ENT_QUOTES, 'UTF-8');
    $chpass = password_hash(htmlspecialchars($_POST["chpass1"]), PASSWORD_DEFAULT);
    $UM->changePasswd($parentID, $chpass);
    header('Location:changeComp.php');
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>パスワード変更 | mamoriO</title>
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
    <script src="../js/sweetalert.min.js"></script>
    <link href="../css/sweetalert.css" rel="stylesheet">
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
                <h4 class="card-title txt-title">パスワード変更</h4>
                <form id="formEmpty" data-smk-icon="glyphicon-remove-sign" action="./passChange.php" method="post">
                    <div class="form-group">
                        <label class="control-label">現在のパスワード</label>
                        <input type="password" id="form-currentPass" class="form-control" name="pass" placeholder="現在のパスワード" data-smk-strongPass="medium" required>
                    </div>
                    <div class="form-group smk-text-muted-in">
                        <label class="control-label">変更後パスワード</label>
                        <div class="text-muted txt-minisize">6文字以上(英数字)</div>
                        <input type="password" id="chpass1" class="form-control" name="chpass1" placeholder="変更後パスワード" data-smk-strongPass="medium" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">変更後パスワード(再入力)</label>
                        <input type="password" id="chpass2" class="form-control" name="chpass2" placeholder="変更後パスワード(再入力)" data-smk-strongPass="medium" required>
                    </div>
                    <div class="button-grp">
                        <button type="button" id="btnEmpty" class="btn btn-warning" name="change">変更</button>
                        <button type="button" class="btn btn-warning" onClick="history.back();">戻る</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        var formIdCheckFlg = false;
        var parentID = <?php echo json_encode($_SESSION['ParentID']); ?>;
        $(document).ready(function(){
            $('#form-currentPass').blur(function(e) {
                formAjax();
            });
            $('#btnEmpty').on('click',function(e) {
                formAjax();
                if ($('#formEmpty').smkValidate()) {
                    if( $.smkEqualPass('#chpass1','#chpass2')){
                        if(formIdCheckFlg){
                            var target = document.getElementById("formEmpty");
                            target.method = "post";
                            target.submit();
                        }else{
                            formIdCheckFlg = false;
                        }
                    }else{
                        formIdCheckFlg = false;
                    }
                }
            });
        });

        function formAjax(){
            var currentPass = document.getElementById('form-currentPass').value;
            $.ajax({
                url: '../ajax/passCollation.php',
                type: 'POST',
                dataType: 'json',
                data: {parentID: parentID,
                 currentPass: currentPass},
                 async: false
             })
            .done(function(data) {
                if(data){
                    formIdCheckFlg = false;
                    swal({
                        title: "パスワードが間違っています",
                        text: "正しいパスワードを入力してください。",
                        type: "error",
                        confirmButtonText: "戻る"
                    });
                } else {
                    formIdCheckFlg = true;
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
               alert("通信エラーがおきました");
               alert(jqXHR);
               alert(textStatus);
               alert(errorThrown);
           });
        }
    </script>
</body>
</html>
