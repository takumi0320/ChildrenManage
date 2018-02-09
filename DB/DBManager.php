<?php
//テーブル用のクラスを読み込む
//DBManagerが使うクラスを読み込む
require_once "../DB/User.php";
require_once "../DB/GPS.php";
require_once "../DB/Child.php";
require_once "../DB/DBInfo.php";

class DBManager{
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

        //挿入のメソッド
    public function insertGPSInformation($GPS){
        try{
                //DBに接続
            $this->dbConnect();
                //GPSManagerのinsertGPSから送られてきた情報をDBに挿入
            $stmt = $this->myPdo->prepare("INSERT INTO GPSTBL(ChildID,GparentID,Day,Time,Latitude,Longitude) VALUES (:childID,:gparentID,:day,:time,:latitude,:longitude)");
            $stmt->bindParam(':childID',$GPS->ChildID,PDO::PARAM_STR);
            $stmt->bindParam(':gparentID',$GPS->GparentID,PDO::PARAM_STR);
            $stmt->bindParam(':day',$GPS->Day,PDO::PARAM_STR);
            $stmt->bindParam(':time',$GPS->Time,PDO::PARAM_STR);
            $stmt->bindParam(':latitude',$GPS->Latitude,PDO::PARAM_STR);
            $stmt->bindParam(':longitude',$GPS->Longitude,PDO::PARAM_STR);
                //SQL実行
            $stmt->execute();
                //DB切断
            $this->dbDisconnect();
        }catch (PDOException $e) {
            print('書き込み失敗。'.$e->getMessage());
            throw $e;
        }
    }

    public function selectGPSNowData($childID, $today){
        try{
                //DBに接続
            $this->dbConnect();
                //GPSManagerのinsertGPSから送られてきた情報をDBに挿入
            $stmt = $this->myPdo->prepare("SELECT MAX(Day) AS Day, MAX(Time) AS Time, Latitude, Longitude FROM GPSTBL WHERE ChildID = :childID AND Day = :today");
            $stmt->bindParam(':childID',$childID,PDO::PARAM_STR);
            $stmt->bindParam(':today',$today,PDO::PARAM_STR);
            //SQL実行
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!empty($row['Time'])){
                $result = new GPS();
                $result->Day = $row['Day'];
                $result->Time = $row['Time'];
                $result->Latitude = $row['Latitude'];
                $result->Longitude = $row['Longitude'];
            } else {
                $result = false;
            }
            //DB接続
            $this->dbDisconnect();
            return $result;
        }catch (PDOException $e) {
            print('書き込み失敗。'.$e->getMessage());
            throw $e;
        }
    }

    public function selectGPSLastData($childID, $today){
        try{
                //DBに接続
            $this->dbConnect();
                //GPSManagerのinsertGPSから送られてきた情報をDBに挿入
            $stmt = $this->myPdo->prepare("SELECT Day, Time, Latitude, Longitude FROM GPSTBL WHERE day = (SELECT MAX(Day) FROM  (SELECT * FROM GPSTBL WHERE ChildID = :childID AND Day <> :today ) as NOTTODAY)");
            $stmt->bindParam(':childID',$childID,PDO::PARAM_STR);
            $stmt->bindParam(':today',$today,PDO::PARAM_STR);
            //SQL実行
            $stmt->execute();
            $retList = array();
            $resultFlg = true;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if(empty($row['Day'])){
                    $resultFlg = false;
                    break;
                }
                $result = new GPS();
                $result->Day = $row['Day'];
                $result->Time = $row['Time'];
                $result->Latitude = $row['Latitude'];
                $result->Longitude = $row['Longitude'];
                array_push($retList, $result);
            }
            //DB接続
            $this->dbDisconnect();
            if($resultFlg === false){
                return $resultFlg;
            } else {
                return $retList;
            }
        }catch (PDOException $e) {
            print('書き込み失敗。'.$e->getMessage());
            throw $e;
        }
    }

        //参照のメソッド
    public function selectGPSDataDayList($childID,$date){
        try{
                //DBに接続
            $this->dbConnect();
            //プリペアドステートメントの生成
            //DATE_FORMATで年月のみ検索
            $stmt = $this->myPdo->prepare("SELECT Day, Time, Latitude, Longitude FROM GPSTBL WHERE ChildID = :childID AND Day = :date");
            $stmt->bindParam(':childID',$childID, PDO::PARAM_STR);
            $stmt->bindParam(':date',$date, PDO::PARAM_STR);
                //SQLを実行
                //取得したデータを１件ずつループしながらクラスに入れていく
            $stmt->execute();
            $retList = array();
            $resultFlg = true;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if(empty($row['Day'])){
                    $resultFlg = false;
                    break;
                }
                $result = new GPS();
                $result->Day = $row['Day'];
                $result->Time = $row['Time'];
                $result->Latitude = $row['Latitude'];
                $result->Longitude = $row['Longitude'];
                array_push($retList, $result);
            }
            $this->dbDisconnect();
            if($resultFlg === false){
                return $resultFlg;
            } else {
                return $retList;
            }
        }catch (PDOException $e) {
            print('参照に失敗。'.$e->getMessage());
        }
    }

    public function selectGPSDataMonthList($childID, $day){
        try{
                //DBに接続
            $this->dbConnect();

                //SQLを生成
                //GPSManagerのmakeGPSListから要求された情報をDBから参照
                //stmtはmysqlで動かす
            $stmt = $this->myPdo->prepare("SELECT Day FROM GPSTBL WHERE ChildID = :childID AND DATE_FORMAT(Day, '%Y%m') = :yearMonth GROUP BY Day ORDER BY Day ASC");
            $stmt->bindParam(':childID',$childID, PDO::PARAM_STR);
            $stmt->bindParam(':yearMonth',$day, PDO::PARAM_STR);
                //SQLを実行
                //取得したデータを１件ずつループしながらクラスに入れていく
            $stmt->execute();
            $dayList = array();
            $i = 0;
            while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
                $dayList[$i] = strtotime($row['Day']);
                $i++;
            }
            $this->dbDisconnect();
                //結果が格納された配列を返す
            return $dayList;
        }catch (PDOException $e) {
            print('参照に失敗。'.$e->getMessage());
        }
    }

    public function insertUserInfomation($User){
        try{
                //DBに接続
            $this->dbConnect();
            $stmt = $this->myPdo->prepare("INSERT INTO ParentTBL(ParentID,ParentName,Pass) VALUES (:parentID,:parentName,:pass)");
            $stmt->bindParam(':parentID',$User->ParentID,PDO::PARAM_STR);
            $stmt->bindParam(':parentName',$User->ParentName,PDO::PARAM_STR);
            $stmt->bindParam(':pass',$User->Pass,PDO::PARAM_STR);
            $stmt->execute();
            $this->dbDisconnect();
        }catch (PDOException $e) {
            print('挿入に失敗しました。'.$e->getMessage());
            throw $e;
        }
    }

    public function changePasswdInfo($parentID, $chpass){
        try{
            $this->dbConnect();
            $stmt = $this->myPdo->prepare("UPDATE ParentTBL SET Pass = :pass WHERE ParentID = :parentID");
            $stmt->bindParam(':parentID',$parentID,PDO::PARAM_STR);
            $stmt->bindParam(':pass',$chpass,PDO::PARAM_STR);
            $stmt->execute();
            $this->dbDisconnect();
        }catch (PDOException $e) {
            print('更新に失敗しました。'.$e->getMessage());
            throw $e;
        }
    }

    public function getChildInfoList($parentID){
        try{
                //DBに接続
            $this->dbConnect();
            $stmt = $this->myPdo->prepare("SELECT * FROM ChildTBL WHERE ParentID = :parentID");
            $stmt->bindParam(':parentID',$parentID,PDO::PARAM_STR);
            $stmt->execute();
            $retList = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $childArray = array();
                $childArray['childID'] = $row['ChildID'];
                $childArray['childName'] = $row['ChildName'];
                array_push($retList, $childArray);
            }
            $this->dbDisconnect();
            return $retList;
        }catch (PDOException $e) {
            print('挿入に失敗しました。'.$e->getMessage());
            throw $e;
        }
    }

    public function getChildInfo($childID){
        try{
                //DBに接続
            $this->dbConnect();
            $stmt = $this->myPdo->prepare("SELECT * FROM ChildTBL WHERE ChildID = :childID");
            $stmt->bindParam(':childID',$childID,PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $result = $row['ChildName'];
            $this->dbDisconnect();
            return $result;
        }catch (PDOException $e) {
            print('挿入に失敗しました。'.$e->getMessage());
            throw $e;
        }
    }

    public function insertChildInfomation($Child){
        try{
                //DBに接続
            $this->dbConnect();
            $stmt = $this->myPdo->prepare("INSERT INTO ChildTBL(ParentID,ChildName) VALUES(:parentID,:childName)");
            $stmt->bindParam(':parentID',$Child->ParentID,PDO::PARAM_STR);
            $stmt->bindParam(':childName',$Child->ChildName,PDO::PARAM_STR);
            $stmt->execute();
            $this->dbDisconnect();
        }catch (PDOException $e) {
            print('挿入に失敗しました。'.$e->getMessage());
            throw $e;
        }
    }

    public function getChildID($Child){
        try{
                //DBに接続
            $this->dbConnect();
            $stmt = $this->myPdo->prepare("SELECT * FROM ChildTBL WHERE ParentID = :parentID AND ChildName = :childName");
            $stmt->bindParam(':parentID',$Child->ParentID,PDO::PARAM_STR);
            $stmt->bindParam(':childName',$Child->ChildName,PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $result = $row['ChildID'];
            $this->dbDisconnect();
            return $result;
        }catch (PDOException $e) {
            print('挿入に失敗しました。'.$e->getMessage());
            throw $e;
        }
    }

        //検索のメソッド
    public function searchUsertInfomation($ParentID){
        try{
                //DBに接続
            $this->dbConnect();
                //プリペアドステートメントの生成
            $stmt = $this->myPdo->prepare("SELECT * FROM ParentTBL WHERE ParentID = :parentID");
            $stmt->bindParam(':parentID', $ParentID, PDO::PARAM_STR);
                //SQLを実行
            $stmt->execute();
            $retList = array();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $retList["ParentID"] = $row['ParentID'];
            $retList["ParentName"] = $row['ParentName'];
            $this->dbDisconnect();
                //結果が格納された配列を返す
            return $retList;
        }catch (PDOException $e) {
            print('検索に失敗しました。'.$e->getMessage());
        }
    }

    public function searchChildtInfomationList($ParentID){
        try{
                //DBに接続
            $this->dbConnect();
                //SQLを生成
                //userIdを検索
            $stmt = $this->myPdo->prepare("SELECT * FROM ChildTBL WHERE ParentID = :parentID;");
            $stmt->bindParam(':parentID', $ParentID, PDO::PARAM_STR);
                //SQLを実行
            $stmt->execute();

            $retList = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    //データを入れるクラスをnew
                $rowData = new Child();
                    //DBから取れた情報をカラム毎に、クラスに入れていく
                $rowData->ParentID = $row["ParentID"];
                $rowData->ChildID = $row["ChildID"];
                $rowData->ChildName = $row["ChildName"];
                    //取得した一件を配列に追加する
                array_push($retList,$rowData);
            }

            $this->dbDisconnect();
                //結果が格納された配列を返す
            return $retList;

        }catch (PDOException $e) {
            print('検索に失敗。'.$e->getMessage());
        }
    }


    public function insertGparentIDinfomation(){
        try{
                //DBに接続
            $this->dbConnect();

            $stmt = $this->myPdo->prepare("INSERT INTO GparentTBL() VALUES ()");
            $stmt->execute();
            $GparentID = $this->myPdo->lastInsertId('GparentID');
            $this->dbDisconnect();
            return $GparentID;

        }catch (PDOException $e) {
            print('挿入に失敗しました。'.$e->getMessage());
            throw $e;
        }
    }
}
?>
