<?php
require_once '../DB/DBManager.php';
require_once '../DB/User.php';
require_once '../DB/Child.php';

class UserManager{
        //registerでuserIdとpassを登録
    public function registerUser($ParentID,$ParentName,$Pass){

        $DBManager = new DBManager();
        $User = new User();
        $User->ParentID = $ParentID;
        $User->ParentName = $ParentName;
        $User->Pass = $Pass;
        $DBManager->insertUserInfomation($User);
    }

    public function searchChildInfo($parentID){
        $DBM = new DBManager();
        $retList = $DBM->getChildInfoList($parentID);
        return $retList;
    }
    public function setChildInfo($childID){
        $DBM = new DBManager();
        $result = $DBM->getChildInfo($childID);
        session_start();
        $_SESSION['ChildID'] = $childID;
        $_SESSION['ChildName'] = $result;
        session_regenerate_id();
        header('Location: ./');
    }

    public function registerChild($ParentID,$ChildName){
        $DBManager = new DBManager;
        $Child = new Child;
        $Child->ParentID = $ParentID;
        $Child->ChildName = $ChildName;
        $DBManager->insertChildInfomation($Child);
        $result = $DBManager->getChildID($Child);
        session_start();
        $_SESSION['ChildID'] = $result;
        $_SESSION['ChildName'] = $ChildName;
        session_regenerate_id();
        header('Location: ./registerChildComp.php');
    }

    public function login($ParentID,$Pass){
        $DBManager = new DBManager();
        $result = $DBManager->searchUsertInfomation($ParentID);
        session_start();
        $_SESSION['ParentID'] = $result['ParentID'];
        $_SESSION['ParentName'] = $result['ParentName'];
        session_regenerate_id();
        header('Location: ./');
    }

    public function registerGparent(){
        $DBManager = new DBManager();
        $GparentID = $DBManager->insertGparentIDinfomation();
        return $GparentID;
    }

    public function changePasswd($parentID, $chpass){
        $DBM = new DBManager();
        $DBM->changePasswdInfo($parentID, $chpass);
    }
}
?>
