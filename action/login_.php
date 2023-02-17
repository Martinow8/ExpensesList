<?php
    session_start();
    if(!isset($_POST['submit'])){
        header("location: ../login.php");
    }

    $username = htmlspecialchars($_POST["username"]);
    $password = md5(htmlspecialchars($_POST["password"]));

    $conn = mysqli_connect('localhost', 'expense','123456','expense');
    if(!$conn){
        echo "Erorr";
    } else {
        echo "Connected!";
    }

    $query = "SELECT * FROM users WHERE username ='$username' AND password = '$password' ";
    $result = mysqli_num_rows(mysqli_query($conn, $query));
    if($result == 0){
        header("location: ../login.php?error=wrongCredentials");
        die;
    } else {
        $_SESSION['logged'] = TRUE;
        $_SESSION['username'] = $username;
        header("location: ../index.php");
    }
?>