<?php
require_once '../DB/AjaxDBManager.php';
class AjaxManager{
	//registerで既にIDが登録されていないか確認
        public function checkUserDuplication($parentID){
            $ADBM = new AjaxDBManager();
            $result = $ADBM->checkUserData($parentID);
            return $result;
        }

        //loginで登録情報が存在するか確認
        public function checkUserData($parentID, $pass){
            $ADBM = new AjaxDBManager();
            $result = $ADBM->collationUserData($parentID,$pass);
            return $result;
        }

        //passChangeで現在のパスワードが合っているか確認
        public function checkPasswd($parentID, $currentPass){
            $ADBM = new AjaxDBManager();
            $result = $ADBM->collationPasswd($parentID, $currentPass);
            return $result;
        }
}
?>