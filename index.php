<?php

require './model/pdo.php';
require './vendor/autoload.php';

use \Monolog\Logger as Logger;
use Monolog\Handler\StreamHandler;
date_default_timezone_set('Asia/Seoul');
ini_set('default_charset', 'utf8mb4');

//error_reporting(E_ALL); ini_set("display_errors", 1);

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    //Main Server API
    $r->addRoute('GET', '/', 'index'); // 기본값
    $r->addRoute('POST', '/user', 'makeUser'); // 아이디 생성
    $r->addRoute('GET', '/user/{userid}', 'showUser'); // 내정보 확인

    $r->addRoute('POST', '/newtrip', 'makeTrip'); //여행일지 생성

    $r->addRoute('GET', '/trip', 'showTrip'); //여행 일지 전체보기
    $r->addRoute('GET', '/mytrip/{userid}', 'showMyTrip'); //내 여행 일지 전체보기

    $r->addRoute('GET', '/trip/{itemno}', 'showPagingTrip'); //여행 일지 페이징네이션
    $r->addRoute('POST', '/tripdelete', 'deleteTrip'); // 여행 일지 삭제


    $r->addRoute('POST', '/info', 'makeInfo'); // 여행 사진들 저장
    $r->addRoute('GET', '/info/{tripno}', 'showTripInfo'); //여행 일지 전체보기


    $r->addRoute('POST', '/satrip', 'saTripmake'); // 아이디 생성
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

// 로거 채널 생성
$accessLogs =  new Logger('BIGS_ACCESS');
$errorLogs =  new Logger('BIGS_ERROR');
// log/your.log 파일에 로그 생성. 로그 레벨은 Info
$accessLogs->pushHandler(new StreamHandler('logs/access.log', Logger::INFO));
$errorLogs->pushHandler(new StreamHandler('logs/errors.log', Logger::ERROR));
// add records to the log
//$log->addInfo('Info log');
// Debug 는 Info 레벨보다 낮으므로 아래 로그는 출력되지 않음
//$log->addDebug('Debug log');
//$log->addError('Error log');

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        echo "404 Not Found";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        echo "405 Method Not Allowed";
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1]; $vars = $routeInfo[2];
        require './controller/mainController.php';

        break;
}




