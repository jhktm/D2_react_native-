<?php
require 'pdoConnect.php';
function makeUser($id, $email, $name)
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

function showUser($userId)
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
function makeTrip($userid, $triptitle, $tripcontent,$tripimg)
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
    $st = null;
    $pdo = null;

}
function showTrip()
{
    $pdo = pdoSqlConnect();
    $query = "select * from trip_DB.Trip_TB";
    $st = $pdo->prepare($query);
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
