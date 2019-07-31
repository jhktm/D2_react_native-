<?php
require 'function.php';

$res = (Object)Array();
header('Content-Type: json');
$req = json_decode(file_get_contents("php://input"));
try {
    addAccessLogs($accessLogs, $req);
    switch ($handler) {
        case "index":
            echo "API Server";
            break;
        case "ACCESS_LOGS":
            //            header('content-type text/html charset=utf-8');
            header('Content-Type: text/html; charset=UTF-8');
            getLogs("./logs/access.log");
            break;
        case "ERROR_LOGS":
            //            header('content-type text/html charset=utf-8');
            header('Content-Type: text/html; charset=UTF-8');
            getLogs("./logs/errors.log");
            break;
        /*
         * API No. 1
         * API Name : 회원정보 저장
         * 마지막 수정 날짜 : 19.07.26
         */
        case "makeUser":
            
            $id = $req->User_ID;
            $email = $req->User_Email;
            $name = $req->User_Name;
            makeUser($id, $email, $name);

            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

         case "saTripmake":



             $id = $req->User_ID;

             $title = $req->Trip_Title;
             $content = $req->Trip_Content;
             $img = $req->Trip_Img;

             saTripmake($id, $title, $content,$img);

             $res->isSuccess = $id;
             $res->code = $title;
             $res->message = $content;
             echo json_encode($res, JSON_NUMERIC_CHECK);
             break;

        /*
         * API No. 2
         * API Name : 회원정보 보여주기
         * 마지막 수정 날짜 : 19.07.26
         */
        case "showUser":
            $id = $vars["userid"];
            $res ->result = showUser($id);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        /*
          * API No. 3
            * API Name :여행 정보 만들기
            * 마지막 수정 날짜 : 19.07.30
            * 마지막 수정 날짜 : 19.07.30
                */
        case "makeTrip":
            $id = $req->User_ID;
            $title = $req->Trip_Title;
            $content = $req->Trip_Content;
            $img = $req->Trip_Img;

            $res->Trip_No = makeTrip($id, $title, $content,$img);


            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        /*
           * API No. 4
         * API Name :여행 정보 보여주기
         * 마지막 수정 날짜 : 19.07.31
           */

         case "showTrip":
             $res->res = showTrip();
             $res->isSuccess = TRUE;
             $res->code = 100;
             $res->message = "성공";
             echo json_encode($res, JSON_NUMERIC_CHECK);
             break;

             /*
       * API No. 4
         * API Name :여행 정보 보여주기
         * 마지막 수정 날짜 : 19.07.31
      */
         case "showPagingTrip":
             $itemid = (int)$vars["itemno"];

             $res->res = showPagingTrip($itemid);
             $res->isSuccess = TRUE;
             $res->code = 100;
             $res->message = "성공";
             echo json_encode($res->res, JSON_NUMERIC_CHECK);
             break;

        /*
         * API No. 5
           * API Name :여행 개별 사진 저장
           * 마지막 수정 날짜 : 19.07.31
        */
        case "makeInfo":
            $tripno = $req->Trip_No;
            $infoimg = $req->Info_Image;
            $infolong = $req->Info_Longitude;
            $infolat = $req->Info_Latitude;
            $infocon = $req->Info_Content;
            $infodate= $req->Info_Date;


            $infotimedate = date("Y-m-d H:i:s", strtotime($infodate));

            makeInfo($tripno, $infoimg, $infolong,$infolat,$infocon,$infotimedate);

            $res->isSuccess = $infotimedate;
            $res->code = 100;
            $res->message = "성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        /* API No. 6
           API Name :여행 세부 보기
           마지막 수정 날짜 : 19.07.31*/

        case "showTripInfo":
            $tripno = $vars["tripno"];


            $res->res = showTripInfo($tripno);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        /* API No. 7
       API Name : 여행 삭제
       마지막 수정 날짜 : 19.07.31*/

        case "deleteTrip":
            $tripno = $req->Trip_No;

            deleteTrip($tripno);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        /* API No. 8
       API Name : 여행 수정
       마지막 수정 날짜 : 19.07.30*/

        case "showMyTrip":
            $userid = $vars["userid"];

            $res->res=showMyTrip($userid);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "성공";
            echo json_encode( $res->res, JSON_NUMERIC_CHECK);
            break;




    }
} catch (\Exception $e) {
    return getSQLErrorException($errorLogs, $e, $req);
}
