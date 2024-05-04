<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


include "connection.php";


class Functions
{

    public function __construct()
    {

        $this->run();

    }

    public function run()
    {
        if (isset($_POST['action'])) {

            switch ($_POST['action']) {
                case 'regisztracio':
                    $this->registration();
                    break;
                case 'Bejelentkezes':
                    $this->login();
                    break;
                case 'kijelentkezes':
                    $this->logOut();
                    break;
                case 'picture':
                    $this->picture();
                    break;
                case 'ResetPass':
                    $this->resetPassword();
                    break;
                case 'ModifyUser':
                    $this->modifyUser();
                    break;
                case 'Send':
                    $this->mailAddAndPasswordChange();
                    break;
                case 'AddWorker':
                    $this->addWorker();
                    break;

                case 'BanPerson':case 'UnBanPerson':
                    $this->ban();
                    break;
                case 'AddTable':
                $this->addTable();
                break;
                default:
                    $_SESSION['message'] = "Something went wrong in switch";
                    header('Location:users.php');
                    exit();
            }
        } elseif (isset($_SESSION['action'])) {
            //Hogyha a fő oldalról jelentkezünk ki akkor get metódust használunk, mivel egy link rákattintásával
            // eltudjuk küldeni az értéket ami szükséges hogy a megfelelő fügvényt elinditsuk
            switch ($_SESSION['action']) {

                case 'kijelentkezes':
                    $this->logOut();
                    break;

            }
        }
    }
    public function addTable()
    {
        if (isset($_POST['cap']) && isset($_POST['ar'])) {
            global $conn;
            $cap = $_POST['cap'];
            $ar = $_POST['ar'];
            if(!empty($_POST['sm']))
            {
                $sm = "Yes";
            }
            else $sm = "No";
            //$this->userCheck1($knev, $vnev, $mail, $tel2, "registration.php?token=".$_SESSION['token']);
            try {
                // SMTP settings
                // Insert user data into the database
                $sql = "INSERT INTO `table` (capacity, area, smokingArea) VALUES (?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iss", $cap, $ar, $sm);
                if ($stmt->execute()) {
                    $_SESSION['message'] = "Table added successfully!";
                    $_SESSION['text'] = "<h2>Add table</h2>";
                    header('Location: tables.php');
                    exit(); // Exit script after redirection
                } else {
                    $_SESSION['message'] = "Error occurred during registration: " . $conn->error;
                    header('Location: addTable.php?token='.$_SESSION['token']);
                    exit();
                }
            }
            catch (Exception $e) {
                $_SESSION['message'] = "An error occurred: " . $e->getMessage();
            }
        }
    }
public function ban()
{
    if(isset($_POST['ban'])){
        try {
            global $conn;
            $time = time();
            $currentTime = date("Y-m-d H:i:s", $time);
            if ($_POST['ban'] == "yes") {
                $sql = mysqli_prepare($conn, "UPDATE user SET banned=0,banned_time=0 WHERE userId=?");
                $_SESSION['message'] = "The person is unbanned";
                $sql->bind_param("i", $_POST['id']);
            } else {
                $sql = mysqli_prepare($conn, "UPDATE user SET banned=1,banned_time=? WHERE userId=?");
                $_SESSION['message'] = "The person is banned";

                $sql->bind_param("si", $currentTime, $_POST['id']);
            }

            $sql->execute();

            header('Location:'.$_SESSION['previousPage']);
            $_SESSION['previousPage'] = "";
            exit();
        }
        catch (Exception $e) {
            $_SESSION['message'] = "Something went wrong";
            header('Location:'.$_SESSION['previousPage']);
            $_SESSION['previousPage'] = "";
            exit();
        }
    }
}

    public function addWorker()
    {
        if (isset($_POST['knev']) && isset($_POST['vnev']) && isset($_POST['tel1']) &&
            isset($_POST['tel2']) && isset($_POST['mail'])) {
            global $conn;
            $knev = $_POST['knev'];
            $vnev = $_POST['vnev'];
            $tel1 = $_POST['tel1'];

            $tel2 = $_POST['tel2'];
            $tel = $tel1 . "" . $tel2;

            $mail = $_POST['mail'];
            $_SESSION["workerEmail"] = $mail;

            $this->userCheck1($knev, $vnev, $mail, $tel2, "registration.php?token=" . $_SESSION['token']);
            try {
                // SMTP settings
                $time = time() + 60 * 10;
                $verification_time = date("Y-m-d H:i:s", $time);

                $sql = "SELECT userMail,verify,verification_time FROM user";
                $stmtTeszt = $conn->query($sql);

                if ($stmtTeszt->num_rows > 0) {
                    while ($rows = $stmtTeszt->fetch_assoc()) {


                        if ($rows["userMail"] == $mail) {
                            $logType = "Adding a Worker";
                            $logText = "The worker is already registered";
                            $mail = $_SESSION['email'];
                            $logMessage = "Worker is in Database!";

                            $this->errorLogInsert($mail, $logText, $logType, $logMessage);
                            header('Location: workers.php');

                            exit();

                        }
                    }

                    $kep = "logInPic.png";

                    // Send email

                    // Hash the password
                    $pass = "";
                    $verification_code = substr(number_format(time() * rand(), 0, '',
                        ''), 0, 7);
                    $banned = 0;
                    $privilage = "Worker";
                    $verrification = 0; // Placeholder for verification_code
                    $banned_time = 0;
                    $verification_code_expire = 0;
                    $verification_code_pass = 0;

                    // Insert user data into the database
                    $sql = "INSERT INTO user (firstName, lastName, phoneNumber, userMail, userPassword, verification_code,verify,profilePic,
                 privilage,verification_time,banned,banned_time,passwordValidation,passwordValidationTime) 
VALUES (?,?,?,?, ?,? ,?, ?,?, ?,?,?,?,?)";
                    $stmt = $conn->prepare($sql);

                    $stmt->bind_param("ssissiisssisss", $knev, $vnev, $tel, $mail, $pass, $verification_code,
                        $verrification, $kep, $privilage, $verification_time,
                        $banned, $banned_time, $verification_code_pass, $verification_code_expire);

                    if ($stmt->execute()) {
                        $_SESSION['workerLink'] = "http://192.168.1.10/Restaurant2.0/resetPassword-mail.php";
                        $_SESSION['message'] = "Woker added Successfully!";
                        $_SESSION['text'] = "<h2>Registration</h2>";
                        $_SESSION['verification_code'] = $verification_code;
                        $_SESSION['workerEmail'] = $mail;
                        header('Location: mail.php');
                        exit(); // Exit script after redirection
                    } else {
                        $_SESSION['message'] = "Error occurred during registration: " . $conn->error;
                        header('Location: registration.php?token=' . $_SESSION['token']);
                        exit();
                    }

                }
            } catch (Exception $e) {
                $_SESSION['message'] = "An error occurred: " . $e->getMessage();
            }
        }
    }

    public function mailAddAndPasswordChange()
    {
        global $conn;
        $_SESSION['message'] = "";
        if (isset($_POST['mailReset'])) {


            $sql = "SELECT userMail FROM user where userMail = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $_POST['mailReset']);
            $stmt->execute();

            $result = $stmt->get_result();
            if ($result->num_rows > 0) {


                while ($row = $result->fetch_assoc()) {
                    if ($row['userMail'] == $_POST['mailReset']) {

                        $mail = $_POST['mailReset'];
                        $time = time();
                        $verification_time = date("Y-m-d H:i:s", $time + 60 * 10);
                        $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
                        $query = mysqli_prepare($conn, "UPDATE user SET passwordValidation = ? ,passwordValidationTime =? WHERE userMail = ?");
                        $query->bind_param("sss", $verification_code, $verification_time, $_POST['mailReset']);
                        $query->execute();
                        $_SESSION['mailReset'] = $mail;
                        $_SESSION['resetCode'] = $verification_code;
                        header('Location: mail.php');
                        exit();
                    } else {

                        $logType = "Password change";
                        $logText = "Not registered E-mail!";
                        $mail = $_POST['mailReset'];
                        $logMessage = "The email or the password doesn't mach up!";
                        $this->errorLogInsert($mail, $logText, $logType, $logMessage);
                        header('Location: logIn.php');
                        exit();
                    }
                }
            } else {
                $_SESSION['message'] = "This Email address doesn't exist!";
                header('Location: resetPassword-mail.php');
                exit();
            }
        }

    }

    public function modifyUser()
    {
        global $conn;
        $count = 0;
        $phoneNumber = $_POST['tel1'] . $_POST['tel2'];
        $sql = mysqli_prepare($conn, "Select firstName, lastName, phoneNumber from user where userMail=?");
        $sql->bind_param('s', $_SESSION['email']);
        $sql->execute();
        $result = $sql->get_result();
        $this->userModifyData($_POST['firstName'], $_POST['lastName'], $_POST['tel2'], "modify.php");
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (isset($_POST['firstName']) && $_POST['firstName'] != "") {
                $sql = mysqli_prepare($conn, "Update user set firstName=? where userMail=?");
                $sql->bind_param('ss', $_POST['firstName'], $_SESSION['email']);
                $sql->execute();
                $count++;
                $_SESSION['name'] = $_POST['firstName'];
            } else
                $_SESSION['name'] = $row['firstName'];
            if (isset($_POST['lastName']) && $_POST['lastName'] != "") {
                $sql = mysqli_prepare($conn, "Update user set lastName=? where userMail=?");
                $sql->bind_param('ss', $_POST['lastName'], $_SESSION['email']);
                $sql->execute();
                $_SESSION['name'] = $_SESSION['name'] . " " . $_POST['lastName'];
                $count++;
            } else
                $_SESSION['name'] = $_SESSION['name'] . " " . $row['lastName'];
            if (isset($_POST['tel1']) && isset($_POST['tel2']) && $_POST['tel2'] != "") {

                $sql = mysqli_prepare($conn, "Update user set phoneNumber=? where userMail=?");
                $sql->bind_param('is', $phoneNumber, $_SESSION['email']);
                $sql->execute();
                $count++;

            }
        }
        if ($count != 0)
            $_SESSION['message'] = "We made changes to your profile";
        else
            $_SESSION['message'] = "There are no changes made to your profile";
        header('Location:index.php');
        exit();
    }

    public function resetPassword()

    {
        global $conn;
        if (isset($_POST['mail']) && isset($_POST['resetPassword']) && isset($_POST['confirmPassword'])) {
            $mail = $_SESSION['email'];
            $pass = $_POST['resetPassword'];
            $pass2 = $_POST['confirmPassword'];


            if ($pass == '') {
                $_SESSION['message'] = "Nincsen kitöltve a <b>Jelszó</b> mező";
                header('Location: resetPassword.php');
                exit();
            }
            if ($pass2 == '') {
                $_SESSION['message'] = "Nincsen kitöltve a <b>Jelszóbiztosítása</b> mező";
                header('Location: resetPassword.php');
                exit();
            }
            if ($pass != $pass2) {
                $_SESSION['message'] = "Nem eggyezik a jelszó";
                header('Location: resetPassword.php');
                exit();
            }
            if (!(preg_match("/[a-z]/", $pass))) {
                $_SESSION['message'] = "Nincsen <b>kisbetű</b> a jelszóban";
                header('Location: resetPassword.php');
                exit();

            }
            if (!(preg_match("/[A-Z]/", $pass))) {
                $_SESSION['message'] = "Nincsen <b>nagybetű</b> a jelszóban";
                header('Location: resetPassword.php');
                exit();

            }
            if (!(preg_match("/[0-9]+/", $pass))) {
                $_SESSION['message'] = "Nem tartalmaz <b>számokat</b> a jelszó";
                header('Location: resetPassword.php');
                exit();

            }
            if (strlen($pass) < 8) {
                $_SESSION['message'] = "A jelszó legalább<b> 8 karaktert</b> kell hogy tartalmazzon";
                header('Location: resetPassword.php');
                exit();
            }

            $newPassword = password_hash($pass, PASSWORD_BCRYPT);
            $sql = "UPDATE user SET userPassword = ? WHERE userMail = ? ";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $newPassword, $mail);

            if ($stmt->execute()) {


                if ($stmt->execute()) {
                    sleep(2);
                    $_SESSION['message'] = "Now you can log in.";
                    header('Location: logIn.php');
                    exit();
                } else {
                    sleep(2);
                    $_SESSION['message'] = "Something went wrong.";
                    header('Location: resetPassword.php');
                    exit();
                }

            }
        }
    }

    public function picture()
    {
        global $conn;
        if (isset($_FILES['picture'])) {
            $target_dir = "C:/xampp/htdocs/Restaurant2.0/Restaurant/pictures/";
            $target_file = $target_dir . basename($_FILES["picture"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $kep = pathinfo($target_file, PATHINFO_FILENAME);
            $kep_dir = $imageFileType;
            $kep = $kep . "." . $kep_dir;
            if ($_FILES['picture']["error"] > 0) {
                echo "Something went wrong during file upload!";
            } else {
                if (is_uploaded_file($_FILES['picture']['tmp_name'])) {

                    $file_name = $_FILES['picture']["name"];
                    $file_temp = $_FILES["picture"]["tmp_name"];
                    $file_size = $_FILES["picture"]["size"];
                    $file_type = $_FILES["picture"]["type"];
                    $file_error = $_FILES['picture']["error"];
                    // The full path as submitted by the browser.
                    // This value does not always contain a real directory structure, and cannot be trusted. Available as of PHP 8.1.0.


                    // http://en.wikipedia.org/wiki/Exchangeable_image_file_format
                    // http://www.php.net/manual/en/book.exif.php


                    echo exif_imagetype($file_temp) . "<br>";

                    if (!exif_imagetype($file_temp)) {
                        $_SESSION['message'] = "File is not a picture!";
                        header('location:  index.php');
                        exit();
                    }
                    $file_size = $file_size / 1024;
                    if ($file_size > 200) {
                        $_SESSION['message'] = "File is to big!";
                        header('location:  index.php');
                        exit();
                    }

                    $ext_temp = explode(".", $file_name); //
                    $extension = end($ext_temp);

                    if (isset($_POST['alias'])) {
                        $alias = $_POST['alias'];
                    } else {
                        $alias = "";
                    }

                    $new_file_name = Date("YmdHis") . "$alias.$extension";
                    // 20171110084338.jpg
                    // 20191112134305-vts.jpg
                    $directory = "C:/xampp/htdocs/Restaurant2.0/pictures/";

                    $upload = "$directory/$new_file_name"; // images/20191112134305-vts.jpg


                    if (!is_dir($directory)) //is_dir("images")
                        mkdir($directory);

                    if (!file_exists($upload)) //images/back.png
                    {
                        if (move_uploaded_file($file_temp, $upload)) {

                            $size = getimagesize($upload);
                            var_dump($size);
                            foreach ($size as $key => $value)
                                echo "$key = $value<br>";

                            echo "<img src=\"$upload\" $size[3] alt=\"$file_name\">";

                            // width="1000" height="669"
                            // <img src="pic.gif" width="1000" height="669" alt="pic" />
                        } else
                            echo "<p><b>Error!</b></p>";
                    } else
                        echo "<p><b>File with this name already exists!</b></p>";
                }


                // Assuming 'profilkep' is a column in your table


                $query = mysqli_prepare($conn, "UPDATE user SET profilePic = ? WHERE userMail= ?");
                $query->bind_param("ss", $new_file_name, $_SESSION['email']);
                $query->execute();
                $_SESSION['profilePic'] = $new_file_name;
                // Redirect to login page after successful upload


                header('Location: ' . $_SESSION['backPic']);
                exit(); // Exit after redirection
            }
        }
    }

    public function logOut()
    {

        $_SESSION = [];
        session_unset();
        session_destroy();

        // Redirect to login page
        header('Location:  index.php');
        exit();
    }

    public function login()
    {
        global $conn;

        $mail = $_POST['mail'];
        $password = $_POST['pass'];

        $sql = "SELECT * FROM user where userMail = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $mail);
        $stmt->execute();
        $result = $stmt->get_result();
        $_SESSION['message'] = "";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['userPassword'] == "") {
                    $errorText = "The worker did not set up a password!";
                    $logType = "Log in";
                    $logMessage = "You have to create a password!";
                    $stmt->close();
                    $this->errorLogInsert($mail, $errorText, $logType, $logMessage);
                    header('Location:resetPassword.php');
                    exit();
                }


                if (password_verify($password, $row['userPassword'])) {
                    if ($row['banned']) {
                        $logText = "User tried to log in while he is banned!";
                        $logType = "Banned";
                        $logMessage = "You have been banned from our website!";
                        $stmt->close();
                        $this->errorLogInsert($mail, $logText, $logType, $logMessage);
                        header('Location: logIn.php');
                        exit();
                    }
                    session_start();
                    $_SESSION['message'] = "";
                    $_SESSION['email'] = $row['userMail'];
                    $_SESSION['name'] = $row['firstName'] . " " . $row['lastName'];
                    $_SESSION['profilePic'] = $row['profilePic'];


                    // Store relevant user information in session variables


                    // Redirect the user to the main page

                    header('Location:  index.php');
                    sleep(2);
                    exit();
                } else {
                    $logText = "Wrong password!";
                    $logType = "Log in";
                    $logMessage = "The email or the password doesn't mach up!";
                    $stmt->close();
                    $this->errorLogInsert($mail, $logText, $logType, $logMessage);
                    header('Location: logIn.php');
                    exit();

                }

            }

        } else {
            $errorText = "Not registered E-mail!";
            $logType = "Log in";
            $logMessage = "The email or the password doesn't mach up!";
            $stmt->close();
            $this->errorLogInsert($mail, $errorText, $logType, $logMessage);
            header('Location: logIn.php');
            exit();

        }

    }

    public function registration()
    {
        if (isset($_POST['knev']) && isset($_POST['vnev']) && isset($_POST['tel1']) && isset($_POST['tel2']) && isset($_POST['mail']) && isset($_POST['pass']) && isset($_POST['pass2'])) {
            global $conn;

            $knev = $_POST['knev'];
            $vnev = $_POST['vnev'];
            $tel1 = $_POST['tel1'];

            $tel2 = $_POST['tel2'];
            $tel = $tel1 . "" . $tel2;

            $mail = $_POST['mail'];
            $_SESSION["email"] = $mail;
            $pass = $_POST['pass'];
            $pass2 = $_POST['pass2'];

            $this->userCheck1($knev, $vnev, $mail, $tel2, "registration.php");

            $this->passwordCheck($pass, $pass2, "registration.php");

            try {
                // SMTP settings
                $time = time();
                $verifyTime=time() + 60 * 10;
                $verification_time = date("Y-m-d H:i:s", $verifyTime);
                $currentTime = date("Y-m-d H:i:s", $time);

                $sql = "SELECT userMail,verify,verification_time FROM user";
                $stmtTeszt = $conn->query($sql);

                if ($stmtTeszt->num_rows > 0) {
                    while ($rows = $stmtTeszt->fetch_assoc()) {


                        if ($rows['userMail'] == $mail) {
                            if ($rows['verify'] == 1) {
                                $_SESSION['message'] = "Nem sikerült a <b>Regisztráció</b> győződjön meg arról hogy jól vitte be az email címét vagy hogy nem regisztrált-e már";
                                header('Location: registration.php');
                                exit();
                            } else {

                                $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
                                $query = mysqli_prepare($conn, "UPDATE user SET verification_code = ? ,verification_time =? WHERE userMail = ?");
                                $query->bind_param("sss", $verification_code, $verification_time, $mail);
                                $query->execute();
                                $_SESSION['message'] = "Ha ön szerint az<b>E-mail</b> cím nincs regisztrálva van, akkor próbálja újra";
                                $_SESSION['verification_code'] = $verification_code;
                                $_SESSION['email'] = $mail;

                                header('Location: mail.php');

                                exit();
                            }

                        }
                    }

                    $kep = "logInPic.png";


                    // Send email

                    // Hash the password
                    $pass = password_hash($pass, PASSWORD_BCRYPT);
                    $verification_code = substr(number_format(time() * rand(), 0, '',
                        ''), 0, 7);
                    $banned = 0;
                    $privilage = "Guest";
                    if ($_POST['rank'])
                        $privilage = "Worker";
                    $banned_time = 0;
                    $verification_code_expire = 0;
                    $verification_code_pass = 0;

                    // Insert user data into the database
                    $sql = "INSERT INTO user (firstName, lastName, phoneNumber, userMail, userPassword,
                  verification_code,verify,profilePic,
                 privilage,registrationTime	,verification_time,banned,banned_time,passwordValidation,passwordValidationTime) 
VALUES (?,?,?,?, ?,? ,?, ?,?, ?,?,?,?,?,?)";
                    $stmt = $conn->prepare($sql);
                    $verrification = 0; // Placeholder for verification_code
                    $stmt->bind_param("ssissiissssisss", $knev, $vnev, $tel, $mail, $pass,
                        $verification_code,
                        $verrification, $kep, $privilage,$currentTime, $verification_time,
                        $banned, $banned_time, $verification_code_pass, $verification_code_expire);

                    if ($stmt->execute()) {
                        $_SESSION['message'] = "We sent an email to you!";
                        $_SESSION['text'] = "<h2>Registration</h2>";
                        $_SESSION['verification_code'] = $verification_code;
                        $_SESSION['mail'] = $mail;
                        header('Location: mail.php');
                        exit(); // Exit script after redirection
                    } else {
                        $_SESSION['message'] = "Error occurred during registration: " . $conn->error;
                        header('Location: registration.php');
                        exit();
                    }

                }
            } catch (Exception $e) {
                echo "An error occurred: " . $e->getMessage();
            }
        }

    }
    public function errorLogInsert($mail, $errorText, $logType, $logMessage)
    {
        global $conn;

        sleep(2);

        $time = time();
        $currentTime = date("Y-m-d H:i:s", $time);

        $sql = "INSERT INTO errorlog( errorType, errorMail, errorText, errorTime) VALUES (?,?,?,?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            $_SESSION['message'] = 'Error in SQL query: ' . $conn->error;
        }

        $stmt->bind_param("ssss", $logType, $mail, $errorText, $currentTime);

        if ($stmt->execute()) {
            $_SESSION['message'] = $logMessage;
        } else {
            $_SESSION['message'] = "NUAH.";
        }

        $stmt->close();


    }
    public function passwordCheck($password, $password2, $location)
    {
        if ($password == '') {
            $_SESSION['message'] = "Nincsen kitöltve a <b>Jelszó</b> mező";
            header('Location: ' . $location);
            exit();
        }
        if ($password2 == '') {
            $_SESSION['message'] = "Nincsen kitöltve a <b>Jelszóbiztosítása</b> mező";
            header('Location: ' . $location);
            exit();
        }
        if ($password != $password2) {
            $_SESSION['message'] = "Nem eggyezik a jelszó";
            header('Location: ' . $location);
            exit();
        }
        if (!(preg_match("/[a-z]/", $password))) {
            $_SESSION['message'] = "Nincsen <b>kisbetű</b> a jelszóban";
            header('Location: ' . $location);
            exit();

        }
        if (!(preg_match("/[A-Z]/", $password))) {
            $_SESSION['message'] = "Nincsen <b>nagybetű</b> a jelszóban";
            header('Location: ' . $location);
            exit();

        }
        if (!(preg_match("/[0-9]+/", $password))) {
            $_SESSION['message'] = "Nem tartalmaz <b>számokat</b> a jelszó";
            header('Location: ' . $location);
            exit();

        }
        if (strlen($password) < 8) {
            $_SESSION['message'] = "A jelszó legalább<b> 8 karaktert</b> kell hogy tartalmazzon";
            header('Location: ' . $location);
            exit();
        }
    }

    public function userCheck1($knev, $vnev, $email, $tel2, $location)
    {
        if ($knev == '') {
            $_SESSION['message'] = "Nincsen kitöltve a <b>First Name</b> mező";
            header('Location: ' . $location);
            exit();
        }
        if ($vnev == '') {
            $_SESSION['message'] = "Nincsen kitöltve a <b>Last Name</b> mező";
            header('Location: ' . $location);
            exit();
        }
        if ($email == '') {
            $_SESSION['message'] = "Nincsen kitöltve a <b>E-mail</b> mező";
            header('Location: ' . $location);
            exit();
        }
        if (preg_match("/[0-9]+/", $knev)) {
            $_SESSION['message'] = "A <b>Keresztnév</b> mező tartalmaz számot";
            header('Location: ' . $location);
            exit();
        }
        if (preg_match("/\s/", $knev)) {
            $_SESSION['message'] = "A <b>Keresztnév</b> mező tartalmaz üres helyet";
            header('Location: ' . $location);
            exit();
        }
        if (preg_match("/[0-9]+/", $vnev)) {
            $_SESSION['message'] = "A <b>Vezetéknév</b> mező tartalmaz számot";
            header('Location: ' . $location);
            exit();
        }
        if (preg_match("/\s/", $vnev)) {
            $_SESSION['message'] = "A <b>Vezetéknév</b> mező tartalmaz üres helyet";
            header('Location: ' . $location);
            exit();
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['message'] = "The <b>E-mail</b> does not exist!";
            header('Location: ' . $location);
            exit();
        }
        if ($tel2 != "") {
            if (strlen($tel2) != 7) {
                $_SESSION['message'] = "A <b>Telefonszám</b> nem létezik";
                header('Location: ' . $location);
                exit();
            }
        } else {
            $_SESSION['message'] = "Nincsen kitöltve a <b>Phone Number</b> mező";
            header('Location: ' . $location);
            exit();
        }

    }

    public function userModifyData($knev, $vnev, $tel2, $location)
    {

        if (preg_match("/[0-9]+/", $knev)) {
            $_SESSION['message'] = "A <b>Keresztnév</b> mező tartalmaz számot";
            header('Location: ' . $location);
            exit();
        }
        if (preg_match("/\s/", $knev)) {
            $_SESSION['message'] = "A <b>Keresztnév</b> mező tartalmaz üres helyet";
            header('Location: ' . $location);
            exit();
        }
        if (preg_match("/[0-9]+/", $vnev)) {
            $_SESSION['message'] = "A <b>Vezetéknév</b> mező tartalmaz számot";
            header('Location: ' . $location);
            exit();
        }
        if (preg_match("/\s/", $vnev)) {
            $_SESSION['message'] = "A <b>Vezetéknév</b> mező tartalmaz üres helyet";
            header('Location: ' . $location);
            exit();
        }
        if ($tel2 != "") {
            if (strlen($tel2) != 7) {
                $_SESSION['message'] = "A <b>Telefonszám</b> nem létezik";
                header('Location: ' . $location);
                exit();
            }
        }


    }
}

$functions = new Functions();


?>
