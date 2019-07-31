<?php
require 'pdoConnect.php';


function makeUser($id, $email, $name) // 유저 생성
{
    $pdo = pdoSqlConnect();
    $query = "insert into User_TB(User_ID, User_Email, User_Name) values (:id,:email,:na)";
    $st = $pdo->prepare($query);
    $st->bindParam(':id', $id);
    $st->bindParam(':email', $email);
    $st->bindParam(':na', $name);
    $st->execute();
    $st = null;
    $pdo = null;

}

function saTripmake($id, $title, $content , $img) // 유저 생성
{
    $pdo = pdoSqlConnect();

    $query = "insert into Trip2_TB(User_No, Trip_Title, Trip_Content, Trip_Img) values (:id,:title,:content,:img)";

    $st = $pdo->prepare($query);

    $st->bindParam(':id', $id);
    $st->bindParam(':title', $title);
    $st->bindParam(':content', $content);
    $st->bindParam(':img', $img);
    
    $st->execute();
    $st = null;
    $pdo = null;

}

function showUser($userId) //내정보 보기
{
    $pdo = pdoSqlConnect();
    $query = "select * from trip_DB.User_TB where User_ID = :userid";
    $st = $pdo->prepare($query);
    $st->bindParam(':userid', $userId);
    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetch();
    $st = null;
    $pdo = null;
    return $res;
}

function makeTrip($userid, $triptitle, $tripcontent, $tripimg) // 여행일지 만들기
{
    $pdo = pdoSqlConnect();
    $query = "insert into trip_DB.Trip_TB(User_No, Trip_Title, Trip_Content, Trip_Img) 
values (:userno,:triptitle,:tripcontent,:tripimg)";
    $st = $pdo->prepare($query);
    $st->bindParam(':userno', $userid);
    $st->bindParam(':triptitle', $triptitle);
    $st->bindParam(':tripcontent', $tripcontent);
    $st->bindParam(':tripimg', $tripimg);
    $st->execute();


    $query = "select Trip_No from trip_DB.Trip_TB where User_No = :userno  order by Trip_Date desc" ;
    $st = $pdo->prepare($query);
    $st->bindParam(':userno', $userid);
    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetch();
    $st = null;
    $pdo = null;
    return $res['Trip_No'];

}

function showTrip() // 여행 전체 보기
{
    $pdo = pdoSqlConnect();
    $query = "select * from trip_DB.Trip_TB where Trip_State = 1 order by Trip_Date desc";
    $st = $pdo->prepare($query);
    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $res;
}


function showPagingTrip($itemno)
{
    $num = (int)$itemno * 5;
    $pdo = pdoSqlConnect();
    $query = "select * from trip_DB.Trip_TB  where Trip_State = 1 order by Trip_Date desc limit :itemno,5";
    $st = $pdo->prepare($query);
    $st->bindParam(':itemno', $num, PDO::PARAM_INT);
    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $res;
}

function makeInfo($tripno, $infoimg, $infolong, $infolat, $infocon, $infodate) // 여행일지 만들기
{
    $pdo = pdoSqlConnect();


    $query = "insert 
into trip_DB.Info_TB(Trip_No, Info_Image, Info_Longitude, Info_Latitude, Info_Content,Info_Date) 
values (:tripno,:infoimg,:infolong,:infolat,:infocon,:infodate)";
    $st = $pdo->prepare($query);
    $st->bindParam(':tripno', $tripno);
    $st->bindParam(':infoimg', $infoimg);
    $st->bindParam(':infolong', $infolong);
    $st->bindParam(':infolat', $infolat);
    $st->bindParam(':infocon', $infocon);
    $st->bindParam(':infodate', $infodate);
    $st->execute();
    $st = null;
    $pdo = null;


}

function showTripInfo($tripno) // 여행세부 정보 가져오기
{
    $pdo = pdoSqlConnect();
    $query = "select *
from trip_DB.Info_TB  where Trip_No = :tripno  order by Info_Date desc";
    $st = $pdo->prepare($query);
    $st->bindParam(':tripno', $tripno);
    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $res;

}

function deleteTrip($tripno) // 여행세부 정보 가져오기
{
    $pdo = pdoSqlConnect();
    $query = "update trip_DB.Trip_TB  set Trip_State = 0 where Trip_No = :tripno ";
    $st = $pdo->prepare($query);
    $st->bindParam(':tripno', $tripno);
    $st->execute();
    $st = null;
    $pdo = null;
}

function showMyTrip($userid) // 여행세부 정보 가져오기
{
    $pdo = pdoSqlConnect();
    $query = "select * from trip_DB.Trip_TB where Trip_State = 1 and User_No = :userid order by Trip_Date desc";
    $st = $pdo->prepare($query);
    $st->bindParam(':userid', $userid);
    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();
    $st = null;
    $pdo = null;
    return $res;

}


//READ
function test()
{
    $pdo = pdoSqlConnect();
    $query = "SELECT * FROM TEST_TB;";

    $st = $pdo->prepare($query);
    //    $st->execute([$param,$param]);
    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

//READ
function testDetail($testNo)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT * FROM TEST_TB WHERE no = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$testNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}

function testPost($name)
{
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO TEST_TB (name) VALUES (?);";

    $st = $pdo->prepare($query);
    $st->execute([$name]);

    $st = null;
    $pdo = null;

}

// CREATE
//    function addMaintenance($message){
//        $pdo = pdoSqlConnect();
//        $query = "INSERT INTO MAINTENANCE (MESSAGE) VALUES (?);";
//
//        $st = $pdo->prepare($query);
//        $st->execute([$message]);
//
//        $st = null;
//        $pdo = null;
//
//    }


// UPDATE
//    function updateMaintenanceStatus($message, $status, $no){
//        $pdo = pdoSqlConnect();
//        $query = "UPDATE MAINTENANCE
//                        SET MESSAGE = ?,
//                            STATUS  = ?
//                        WHERE NO = ?";
//
//        $st = $pdo->prepare($query);
//        $st->execute([$message, $status, $no]);
//        $st = null;
//        $pdo = null;
//    }

// RETURN BOOLEAN
//    function isRedundantEmail($email){
//        $pdo = pdoSqlConnect();
//        $query = "SELECT EXISTS(SELECT * FROM USER_TB WHERE EMAIL= ?) AS exist;";
//
//
//        $st = $pdo->prepare($query);
//        //    $st->execute([$param,$param]);
//        $st->execute([$email]);
//        $st->setFetchMode(PDO::FETCH_ASSOC);
//        $res = $st->fetchAll();
//
//        $st=null;$pdo = null;
//
//        return intval($res[0]["exist"]);
//
//    }
