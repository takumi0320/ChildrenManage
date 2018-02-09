<?php
require_once "../DB/DBInfo.php";
class AjaxDBManager{
	private $myPdo;
	//接続のメソッド
	public function dbConnect(){
		try{
			$DBI = new DBInfo();
			$this->myPdo = new PDO('mysql:host=' . $DBI->dbhost . ';dbname=' . $DBI->dbname  . ';charset=utf8', $DBI->user, $DBI->password, array(PDO::ATTR_EMULATE_PREPARES => false));
		}catch(PDOException $e) {
			print('データベース接続失敗。'.$e->getMessage());
			throw $e;
		}
	}

    //切断のメソッド
	public function dbDisconnect(){
		unset($myPdo);
	}

	public function checkUserData($parentID){
		try{
			$this->dbConnect();
			$stmt = $this->myPdo->prepare("SELECT * FROM ParentTBL WHERE ParentID = :parentID");
			$stmt->bindParam(':parentID', $parentID, PDO::PARAM_STR);
			$stmt->execute();
			$result = false;
			if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$result = true;
			}
			$this->dbDisconnect();
			return $result;
		}catch (PDOException $e){
			print('チェックに失敗しました。'.$e->getMessage());
			throw $e;
		}
	}

	public function collationUserData($parentID,$passwd){
		try{
			$this->dbConnect();
			$stmt = $this->myPdo->prepare("SELECT * FROM ParentTBL WHERE ParentID = :parentID");
			$stmt->bindParam(':parentID', $parentID, PDO::PARAM_STR);
			$stmt->execute();
			$result = true;
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$dpass = $row['Pass'];
			$pCheckResult = $this->passwordCheck($passwd, $dpass);
			if($pCheckResult){
				$result = false;
			}
			$this->dbDisconnect();
			return $result;
		}catch (PDOException $e){
			print('チェックに失敗しました。'.$e->getMessage());
			throw $e;
		}
	}

	public function collationPasswd($parentID, $currentPass){
		try{
			$this->dbConnect();
			$stmt = $this->myPdo->prepare("SELECT * FROM ParentTBL WHERE ParentID = :parentID");
			$stmt->bindParam(':parentID', $parentID, PDO::PARAM_STR);
			$stmt->execute();
			$result = true;
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$dpass = $row['Pass'];
			$pCheckResult = $this->passwordCheck($currentPass, $dpass);
			if($pCheckResult){
				$result = false;
			}
			$this->dbDisconnect();
			return $result;
		} catch(PDOException $e) {
			print('チェックに失敗しました' . $e->getMessage());
			throw $e;
		}
	}

	private function passwordCheck($passwd, $hashPass){
		$result = password_verify($passwd, $hashPass);
		return $result;
	}
}
?>