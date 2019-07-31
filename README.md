# D2_react_native-travel_app
리액트 네이티브 기반 여행일지 기록 앱
서버 
Lemp 기반의 AWS서버 입니다.
# 주요 API 명세
https://docs.google.com/spreadsheets/d/1bR13MkuPWYj3beeEOXH630K8zAPEHrxoZCUtlBUE2Q4/edit?usp=sharing

# 코드 흐름

index.php 파일에서 uri 및 useful방식으로 method 확인후 maincontroller.php로 파일을 보냄
req 는 post방식의 데이터를 바디에서 가져오고 var 방식은 uri의 정보를 가져옵니다.
대부분 pdo.php로가서 데이터를 가져옵니다. 서버에는 존재하나 데이터베이스 정보를 가져오는 부분은 gitignore 처리 했습니다.

