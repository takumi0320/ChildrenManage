<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>登録画面 | mamoriO</title>
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
                <h4 class="card-title txt-title">ユーザー登録</h4>
                <form id="formEmpty" data-smk-icon="glyphicon-remove-sign" action="./registerCheck.php" method="post">
                    <div class="form-group">
                        <label class="control-label">ニックネーム</label>
                        <input type="text" class="form-control" name="username" placeholder="ニックネーム" required>
                    </div>
                    <div class="form-group smk-text-muted-in">
                        <label class="control-label">ユーザーID</label>
                        <div class="text-muted txt-minisize">8文字以上20文字以下</div>
                        <input type="text" id="form-userid" class="form-control" name="userid" minlength="8" maxlength="20" placeholder="ユーザーID" required>
                    </div>
                    <div class="form-group smk-text-muted-in">
                        <label class="control-label">パスワード</label>
                        <div class="text-muted txt-minisize">6文字以上(英数字)</div>
                        <input type="password" id="pass1" class="form-control" name="pass" placeholder="パスワード" data-smk-strongPass="medium" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">パスワード(再入力)</label>
                        <input type="password" id="pass2" class="form-control" placeholder="パスワード(再入力)" data-smk-strongPass="medium" required>
                    </div>
                    <div class="button-grp">
                        <button type="button" id="btnEmpty" class="btn btn-warning">登録確認</button>
                        <button type="button" class="btn btn-warning" onClick="history.back();">戻る</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
    <script>
        var formIdCheckFlg = false;
        $(document).ready(function(){
            $('#form-userid').blur(function(e) {
                formAjax();
            });
            $('#btnEmpty').on('click',function(e) {
                formAjax();
                if ($('#formEmpty').smkValidate()) {
                // Code here
                if(formIdCheckFlg){
                    var target = document.getElementById("formEmpty");
                    target.method = "post";
                    target.submit();
                } else {
                    formIdCheckFlg = false;
                }
            }
        });
        });
        function formAjax(){
            var userid = document.getElementById('form-userid').value;
            $.ajax({
                url: '../ajax/register.php',
                type: 'POST',
                dataType: 'json',
                data: {ParentID: userid},
                async: false
            })
            .done(function(data) {
                if(data){
                    formIdCheckFlg = false;
                    swal({
                        title: "存在しているIDです",
                        text: "違うIDを入力してください",
                        type: "error",
                        confirmButtonText: "戻る"
                    });
                } else {
                    formIdCheckFlg = true;
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                alert("通信エラーがおきました");
            });   
        }
    </script>
</body>
</html>
