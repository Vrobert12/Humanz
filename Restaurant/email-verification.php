<?php
include 'connection.php';
global $conn;
if (isset($_POST['verify_email']) && isset($_SESSION['mailReset'])) {
    $sql = "SELECT passwordValidation,passwordValidationTime FROM user WHERE userMail=?";
    $stmtTeszt = $conn->prepare($sql);
    $stmtTeszt->bind_param("s", $_SESSION['email']);
    $stmtTeszt->execute();
    $result = $stmtTeszt->get_result();
    $time = time();
    $check_time = date("Y-m-d H:i:s", $time);
    if ($result->num_rows > 0) {
        while ($rows = $result->fetch_assoc()) {
            if ($rows['passwordValidationTime'] <= $check_time) {

                $mail = $_SESSION['email'];
                $time = time() + 60 * 10;
                $verification_time = date("Y-m-d H:i:s", $time);
                $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
                $query = mysqli_prepare($conn, "UPDATE user SET passwordValidation = ? ,passwordValidationTime =? WHERE userMail = ?");
                $query->bind_param("sss", $verification_code, $verification_time, $mail);
                $query->execute();

                $_SESSION['message'] = "Validation time has expired.";
                header('Location: mail.php');

                exit();

            } else {
                if ($rows['passwordValidation'] == $_POST['verification_code']) {
                    $_SESSION['message'] = "Now you can change the password.";
                    header('Location: resetPassword.php');

                    exit();

                } else {
                    $_SESSION['message'] = "This code is not valid on our page.";
                }
            }
        }
    }


}

if (isset($_POST['verify_email']) && isset($_SESSION['email'])) {
    $sql = "SELECT verification_time,verification_code FROM user WHERE userMail=?";
    $stmtTeszt = $conn->prepare($sql);
    $stmtTeszt->bind_param("s", $_SESSION['email']);
    $stmtTeszt->execute();
    $result = $stmtTeszt->get_result();
    $time = time();
    $check_time = date("Y-m-d H:i:s", $time);
    if ($result->num_rows > 0) {
        while ($rows = $result->fetch_assoc()) {
            if ($rows['verification_time'] <= $check_time) {

                $mail = $_SESSION['email'];
                $time = time() + 60 * 10;
                $verification_time = date("Y-m-d H:i:s", $time);
                $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
                $query = mysqli_prepare($conn, "UPDATE user SET verification_code = ? ,verification_time =? WHERE userMail = ?");
                $query->bind_param("sss", $verification_code, $verification_time, $mail);
                $query->execute();
                $_SESSION['message'] = "This code is not valid on our page.<br> If you are registered than we sent you email with new code.";
                $_SESSION['verification_code'] = $verification_code;
                sleep(2);

                $mail = $_SESSION['email'];
                $logType = "E-mail validation";
                $errorText = "Time for validation has expired";
                $logMessage = $_SESSION['message'];
                errorLogInsert($logType, $mail, $errorText, $logMessage);

                header('Location: mail.php');

                exit();

            } else {
                if ($rows['verification_code'] == $_POST['verification_code']) {


                    $email = $_POST['email'];
                    $verification_code = $_POST['verification_code'];

                    $sql = "UPDATE user SET verify = 1 WHERE userMail = ? AND verification_code = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("si", $email, $verification_code);

                    if ($stmt->execute()) {
                        sleep(2);
                        $_SESSION['message'] = "Now you may log in";
                        header('Location: logIn.php');

                        exit();
                    } else {
                        sleep(2);
                        $_SESSION['message'] = "Verification failed";
                    }

                } else {
                    sleep(2);
                    $_SESSION['message'] = "This code is not valid on our page.";
                    $mail = $_SESSION['email'];
                    $logType = "E-mail validation";
                    $errorText = "The validation code is not correct!";
                    $logMessage = $_SESSION['message'];
                    errorLogInsert($logType, $mail, $errorText, $logMessage);
                    header('Location:email-verification.php');
                    exit();
                }
            }
        }
    }

}
function errorLogInsert($logType, $mail, $errorText, $logMessage)
{
    global $conn;

    sleep(2);

    $time = time();
    $currentTime = date("Y-m-d H:i:s", $time);

    $sql = "INSERT INTO errorlog( errorType, errorMail, errorText, errorTime) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die('Error in SQL query: ' . $conn->error);
    }

    $stmt->bind_param("ssss", $logType, $mail, $errorText, $currentTime);

    if ($stmt->execute()) {
        $_SESSION['message'] = $logMessage;
    } else {
        $_SESSION['message'] = "NUAH.";
    }

    $stmt->close();


}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="SideStyle.css">

</head>
<body>
<form method="post" action="email-verification.php" class="mainForm">
    <label for="verification_code">Enter your code.</label><br>
    <input type="hidden" name="email" class="inputok"
           value="<?php if (isset($_SESSION['email'])) echo htmlspecialchars($_SESSION['email']); ?>">
    <input type="text" name="verification_code" class="inputok" placeholder="Enter verification code"><br>
    <input type="submit" name="verify_email" class="inputok" value="Verify Email">


    <?php


    $message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
    if (isset($_SESSION['message'])) {
        echo "<p class='success'>" . $message . "</p>";


    } ?>

</form>
</body>
</html>
