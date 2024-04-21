<?php
include 'connection.php';
global $conn;

if (isset($_POST['verify_email']) && isset($_SESSION['email'])) {
    $sql = "SELECT verification_time,verification_code FROM user WHERE regisztraloEmail=?";
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
                $query = mysqli_prepare($conn, "UPDATE user SET verification_code = ? ,verification_time =? WHERE regisztraloEmail = ?");
                $query->bind_param("sss", $verification_code, $verification_time, $mail);
                $query->execute();
                $_SESSION['message'] = "Ez a kód lejárt az oldalunkon, ha ön szerint regisztrálva<br> van az email címe nézze meg hogy 
                kapott-e egy érvényes verifikációs kódot.";
                $_SESSION['verification_code'] = $verification_code;

                header('Location: mail.php');

                exit();

            } else {
                if ($rows['verification_code'] == $_POST['verification_code']) {


                    $email = $_POST['email'];
                    $verification_code = $_POST['verification_code'];

                    $sql = "UPDATE user SET verify = 1 WHERE regisztraloEmail = ? AND verification_code = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("si", $email, $verification_code);

                    if ($stmt->execute()) {
                        $_SESSION['message'] = "Most már be bír jelentekezni";
                        header('Location: logIn.php');

                        $sqlTeszt = "select * from user";
                        $stmtTeszt = $conn->query($sqlTeszt);
                        if ($stmtTeszt->num_rows > 0) {
                            while ($rows = $stmtTeszt->fetch_assoc()) {


                            }
                        }

                        exit();
                    } else {
                        echo "Verification failed";
                    }

                }    else{
                    $_SESSION['message'] = "Ez a kód nem érvényes az oldalunkon.";
                }
            }
        }
    }
}
if (isset($_SESSION['message'])) {
    echo "<b>" . $_SESSION['message'] . "</b>";
}
?>
<form method="post">
    <input type="hidden" name="email"
           value="<?php if (isset($_SESSION['message'])) echo htmlspecialchars($_SESSION['email']); ?>" required>
    <input type="text" name="verification_code" placeholder="Enter verification code" required>
    <input type="submit" name="verify_email" value="Verify Email">
</form>