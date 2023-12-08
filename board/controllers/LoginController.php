<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT'] . '/models/UserModel.php');

$servername = "localhost";
$username = "jh";
$password = "1234";
$dbname = "forum";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// POST된 이메일과 패스워드
$email = $_POST['email'];
$userPassword = $_POST['password'];
// UserModel 인스턴스 생성
$userModel = new UserModel($conn);

// 이메일로 사용자 데이터 가져오기
$userData = $userModel->getUserByEmail($email);

if ($userData) {
    // 이메일에 해당하는 사용자가 있을 경우 비밀번호 확인
    if (password_verify($userPassword, $userData['password'])) {

        // 패스워드가 일치하면 로그인 성공
        echo "<script>alert('로그인 성공!');
        window.location.href = '../views/post_list.php';</script>";
        exit();

        // 여기에 세션 설정 등 로그인 후 처리하는 로직 추가
    } else {
        echo "<script>alert('비밀번호가 일치하지 않습니다.');
        window.location.href = '../login.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('해당 이메일의 사용자가 없습니다.');
    window.location.href = '../login.php';</script>";
    exit();
}

// 데이터베이스 연결 닫기
$conn->close();
?>