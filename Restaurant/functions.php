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
                case 'registration':
                    $this->registration();
                    break;
                case 'Log in':
                    $this->login();
                    break;
                case 'kijelentkezes':
                    $this->logOut();
                    break;
                case 'picture':
                    $this->picture($_SESSION['backPic']);
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
                case 'ModifyTable':
                    $this->modifyTable();
                    break;
                case 'AddMenu':
                    $this->addMenu();
                    break;
                case 'ModifyDish':
                    $this->modifyMenu();
                    break;
                case 'BanPerson':
                case 'UnBanPerson':
                    $this->ban();
                    break;
                case 'AddTable':
                    $this->addTable();
                    break;
                default:
                    $_SESSION['message'] = "Something went wrong in switch";
                    header('Location:index.php');
                    exit();
            }
        } elseif (isset($_SESSION['action'])) {

            switch ($_SESSION['action']) {

                case 'kijelentkezes':
                    $this->logOut();
                    break;

            }
        }
    }
    public function modifyMenu()
    {

        $_SESSION['message'] = "Nothing was modified!";

        if (isset($_POST['dishName']) || isset($_POST['dishType'])  || isset($_POST['dishPrice']) || !empty($_FILES['picture']['name'])) {
            global $conn;

            try {

                if (isset($_POST['dishType']) && $_POST['dishType'] != 'Type') {

                    $dishType = $_POST['dishType'];

                    if (is_numeric($dishType)) {
                        $_SESSION['message'] = "The dish type can not contain a number!";
                        header('Location: modifyTable.php');
                        exit();
                    }

                    $sql = "update menu set dishType=? where dishId=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("si", $dishType, $_POST['menuId']);
                    if ($stmt->execute()) {

                        $_SESSION['message'] = "Menu has been modified successfully!";
                        $_SESSION['text'] = "<h2>Modify table</h2>";

                    } else {
                        $_SESSION['message'] = "Error occurred during Modification: " . $conn->error;
                        header('Location: modifyMenu.php');
                        exit();

                    }
                }

                if (isset($_POST['dishName']) && $_POST['dishName'] != '') {

                    $dishName = $_POST['dishName'];

                    if (is_numeric($dishName)) {
                        $_SESSION['message'] = "The dish name can not contain number";
                        header('Location: modifyTable.php');
                        exit();
                    }

                    $sql = "update menu set dishName=? where dishId=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("si", $dishName, $_POST['menuId']);
                    if ($stmt->execute()) {

                        $_SESSION['message'] = "Menu has been modified successfully!";
                        $_SESSION['text'] = "<h2>Modify table</h2>";

                    } else {
                        $_SESSION['message'] = "Error occurred during Modification: " . $conn->error;
                        header('Location: modifyMenu.php');
                        exit();

                    }
                }
                if (!empty($_FILES['picture']['name'])) {

                    $picture = $this->picture("modifyMenu.php");

                    $sql = "update menu set dishPicture=? where dishId=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("si", $picture, $_POST['menuId']);
                    if ($stmt->execute()) {

                        $_SESSION['message'] = "Menu has been modified successfully!";
                        $_SESSION['text'] = "<h2>Modify table</h2>";

                    } else {
                        $_SESSION['message'] = "Error occurred during Modification: " . $conn->error;
                        header('Location: modifyTable.php');
                        exit();

                    }
                }
                if (isset($_POST['dishPrice']) && $_POST['dishPrice'] != '') {

                    $dishPrice = $_POST['dishPrice'];

                    if (!is_numeric($dishPrice)) {
                        $_SESSION['message'] = "The dish price can not contain number";
                        header('Location: modifyTable.php');
                        exit();
                    }

                    $sql = "update menu set dishPrice=? where dishId=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("si", $dishPrice, $_POST['menuId']);
                    if ($stmt->execute()) {

                        $_SESSION['message'] = "Menu has been modified successfully!";
                        $_SESSION['text'] = "<h2>Modify table</h2>";

                    } else {
                        $_SESSION['message'] = "Error occurred during Modification: " . $conn->error;
                        header('Location: modifyMenu.php');
                        exit();

                    }
                }
                header('Location: menu.php');
                exit();
            } catch (Exception $e) {
                $_SESSION['message'] = "An error occurred: " . $e->getMessage();
            }
        }
    }
    public function addMenu()
    {
        if (isset($_POST['dishName']) && isset($_POST['dishType']) && isset($_POST['dishPrice'])) {
            global $conn;
            $dishName = $_POST['dishName'];
            $dishType = $_POST['dishType'];
            $dishPrice = $_POST['dishPrice'];
            $picture = $this->picture("addMenu.php");

            if (empty($_FILES['picture']['name'])) {
                $_SESSION['message'] = "You must add a picture";
                header('Location:addMenu.php');
                exit();
            }
            if ($dishName == '') {
                $_SESSION['message'] = "The number of dish name must contain data";
                header('Location:addMenu.php');
                exit();
            }
            if ($dishType == 'Type') {
                $_SESSION['message'] = "The dish type name must contain data";
                header('Location:addMenu.php');
                exit();
            }

            if ($dishPrice == '') {
                $_SESSION['message'] = "The dish price name must contain data";
                header('Location:addMenu.php');
                exit();
            }

            if (!is_numeric($dishPrice)) {
                $_SESSION['message'] = "The dish price can not contain number";
                header('Location:addMenu.php');
                exit();
            }
            try {

                $sql = "INSERT INTO menu (dishName, dishPicture, dishType,dishPrice) VALUES (?,?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssi", $dishName, $picture, $dishType, $dishPrice);
                if ($stmt->execute()) {

                    $_SESSION['message'] = "Menu added successfully!";
                    $_SESSION['text'] = "<h2>Add table</h2>";
                    header('Location: menu.php');
                    exit(); // Exit script after redirection
                } else {
                    $_SESSION['message'] = "Error occurred during adding table: " . $conn->error;
                    header('Location: addTable.php?token=' . $_SESSION['token']);
                    exit();
                }
            } catch (Exception $e) {
                $_SESSION['message'] = "An error occurred: " . $e->getMessage();
                header('Location:addMenu.php');
                exit();
            }
        } else {

            $_SESSION['message'] = "An error occurred: ";
            header('Location:addMenu.php');
            exit();
        }
    }

    public function modifyTable()
    {

        $_SESSION['message'] = "Nothing was modified!";
        global $conn;
        $sql = "SELECT smokingArea FROM `table`  where tableId=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_POST['tableId']);
        $stmt->execute();

        $result = $stmt->get_result();
        if (isset($_POST['sm']))
            $sm = "Yes";

        else $sm = "No";

        if (isset($_POST['cap']) || isset($_POST['ar']) || $result != $sm || !empty($_FILES['picture']['name'])) {
            global $conn;


            try {
                if ($result != $sm) {
                    $sql = "update `table` set smokingArea=? where tableId=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("si", $sm, $_POST['tableId']);
                    if ($stmt->execute()) {

                        $_SESSION['message'] = "Table modified successfully!";
                        $_SESSION['text'] = "<h2>Modify table</h2>";

                    } else {
                        $_SESSION['message'] = "Error occurred during Modification: " . $conn->error;
                        header('Location:  modifyTable.php');
                        exit();

                    }
                }
                if (isset($_POST['cap']) && $_POST['cap'] != 'Select') {

                    $cap = $_POST['cap'];

                    if (!is_numeric($cap)) {
                        $_SESSION['message'] = "The number of capacity must be a number";
                        header('Location: modifyTable.php');
                        exit();
                    }

                    $sql = "update `table` set capacity=? where tableId=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ii", $cap, $_POST['tableId']);
                    if ($stmt->execute()) {

                        $_SESSION['message'] = "Table modified successfully!";
                        $_SESSION['text'] = "<h2>Modify table</h2>";

                    } else {
                        $_SESSION['message'] = "Error occurred during Modification: " . $conn->error;
                        header('Location: modifyTable.php');
                        exit();

                    }
                }

                if (isset($_POST['ar']) && $_POST['ar'] != '') {

                    $ar = $_POST['ar'];

                    if (is_numeric($ar)) {
                        $_SESSION['message'] = "The Area can not contain number";
                        header('Location: modifyTable.php');
                        exit();
                    }

                    $sql = "update `table` set area=? where tableId=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("si", $ar, $_POST['tableId']);
                    if ($stmt->execute()) {

                        $_SESSION['message'] = "Table modified successfully!";
                        $_SESSION['text'] = "<h2>Modify table</h2>";

                    } else {
                        $_SESSION['message'] = "Error occurred during Modification: " . $conn->error;
                        header('Location: modifyTable.php');
                        exit();

                    }
                }
                if (!empty($_FILES['picture']['name'])) {

                    $picture = $this->picture("modifyTable.php");

                    $sql = "update `table` set reservationPicture=? where tableId=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("si", $picture, $_POST['tableId']);
                    if ($stmt->execute()) {

                        $_SESSION['message'] = "Table modified successfully!";
                        $_SESSION['text'] = "<h2>Modify table</h2>";

                    } else {
                        $_SESSION['message'] = "Error occurred during Modification: " . $conn->error;
                        header('Location: modifyTable.php');
                        exit();

                    }
                }
                header('Location: tables.php');
                exit();
            } catch (Exception $e) {
                $_SESSION['message'] = "An error occurred: " . $e->getMessage();
            }
        }
    }

    public function addTable()
    {

        if (isset($_POST['cap']) && isset($_POST['ar'])) {
            global $conn;
            $cap = $_POST['cap'];
            $ar = $_POST['ar'];
            $picture = $this->picture("addTable.php");
            if (isset($_POST['sm'])) {
                $sm = "Yes";
            } else $sm = "No";
            if (empty($_FILES['picture']['name'])) {
                $_SESSION['message'] = "You must add a picture";
                header('Location:addTable.php');
                exit();
            }

            if ($ar == '') {
                $_SESSION['message'] = "The Areas name must contain data";
                header('Location:addTable.php');
                exit();
            }
            if ($cap == '') {
                $_SESSION['message'] = "The number of capacity must contain data";
                header('Location:addTable.php');
                exit();
            }
            if (!is_numeric($cap)) {
                $_SESSION['message'] = "The number of capacity must be a number";
                header('Location:addTable.php');
                exit();
            }
            if (is_numeric($ar)) {
                $_SESSION['message'] = "The Area can not contain number";
                header('Location:addTable.php');
                exit();
            }
            try {

                $sql = "INSERT INTO `table` (capacity, area, reservationPicture,smokingArea) VALUES (?,?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("isss", $cap, $ar, $picture, $sm);
                if ($stmt->execute()) {

                    $_SESSION['message'] = "Table added successfully!";
                    $_SESSION['text'] = "<h2>Add table</h2>";
                    header('Location: tables.php');
                    exit(); // Exit script after redirection
                } else {
                    $_SESSION['message'] = "Error occurred during adding table: " . $conn->error;
                    header('Location: addTable.php?token=' . $_SESSION['token']);
                    exit();
                }
            } catch (Exception $e) {
                $_SESSION['message'] = "An error occurred: " . $e->getMessage();
            }
        }
    }

    public function ban()
    {
        if (isset($_POST['ban'])) {
            try {
                global $conn;
                $time = time();
                $currentTime = date("Y-m-d H:i:s", $time);
                if ($_POST['ban'] == "yes") {
                    $sql = mysqli_prepare($conn, "UPDATE user SET banned=0,banned_time=? WHERE userId=?");
                    $_SESSION['message'] = "The person is unbanned";
                    $sql->bind_param("si", $currentTime, $_POST['id']);
                } else {
                    $sql = mysqli_prepare($conn, "UPDATE user SET banned=1,banned_time=? WHERE userId=?");
                    $_SESSION['message'] = "The person is banned";

                    $sql->bind_param("si", $currentTime, $_POST['id']);
                }

                $sql->execute();

                header('Location:' . $_SESSION['previousPage']);
                $_SESSION['previousPage'] = "";
                exit();
            } catch (Exception $e) {
                $_SESSION['message'] = "Something went wrong";
                header('Location:' . $_SESSION['previousPage']);
                $_SESSION['previousPage'] = "";
                exit();
            }
        }
    }

    public function addWorker()
    {
        if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['tel1']) &&
            isset($_POST['tel2']) && isset($_POST['mail'])) {
            global $conn;
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $tel1 = $_POST['tel1'];

            $tel2 = $_POST['tel2'];
            $tel = $tel1 . "" . $tel2;

            $mail = $_POST['mail'];
            $_SESSION["workerEmail"] = $mail;

            $this->userCheck1($fname, $lname, $mail, $tel2, "registration.php?token=" . $_SESSION['token']);
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
                    $banned_time = null;
                    $verification_code_expire = null;
                    $verification_code_pass = null;

                    // Insert user data into the database
                    $sql = "INSERT INTO user (firstName, lastName, phoneNumber, userMail, userPassword, verification_code,verify,profilePic,
                 privilage,verification_time,banned,banned_time,passwordValidation,passwordValidationTime) 
VALUES (?,?,?,?, ?,? ,?, ?,?, ?,?,?,?,?)";
                    $stmt = $conn->prepare($sql);

                    $stmt->bind_param("ssissiisssisss", $fname, $lname, $tel, $mail, $pass, $verification_code,
                        $verrification, $kep, $privilage, $verification_time,
                        $banned, $banned_time, $verification_code_pass, $verification_code_expire);

                    if ($stmt->execute()) {
                        $_SESSION['workerLink'] = "http://192.168.1.10/Restaurant/resetPassword-mail.php";
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
                $_SESSION['message'] = "First name is modified";
            } else
                $_SESSION['name'] = $row['firstName'];
            if (isset($_POST['lastName']) && $_POST['lastName'] != "") {
                $sql = mysqli_prepare($conn, "Update user set lastName=? where userMail=?");
                $sql->bind_param('ss', $_POST['lastName'], $_SESSION['email']);
                $sql->execute();
                $_SESSION['name'] = $_SESSION['name'] . " " . $_POST['lastName'];
                $count++;
                $_SESSION['message'] = "Last name is modified";
            } else
                $_SESSION['name'] = $_SESSION['name'] . " " . $row['lastName'];
            if (isset($_POST['tel1']) && isset($_POST['tel2']) && $_POST['tel2'] != "") {

                $sql = mysqli_prepare($conn, "Update user set phoneNumber=? where userMail=?");
                $sql->bind_param('is', $phoneNumber, $_SESSION['email']);
                $sql->execute();
                $count++;
                $_SESSION['message'] = "Phone number is modified";
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
                $_SESSION['message'] = "The <b>Password</b> is not filled out";
                header('Location: resetPassword.php');
                exit();
            }
            if ($pass2 == '') {
                $_SESSION['message'] = "The <b>Confirmation Password</b> is not filled out";
                header('Location: resetPassword.php');
                exit();
            }
            if ($pass != $pass2) {
                $_SESSION['message'] = "The Passwords do not match";
                header('Location: resetPassword.php');
                exit();
            }
            if (!(preg_match("/[a-z]/", $pass))) {
                $_SESSION['message'] = "The <b>Password</b> does not contain <b>Lower case</b>";
                header('Location: resetPassword.php');
                exit();

            }
            if (!(preg_match("/[A-Z]/", $pass))) {
                $_SESSION['message'] = "The <b>Password</b> does not contain <b>Upper case</b>.";
                header('Location: resetPassword.php');
                exit();

            }
            if (!(preg_match("/[0-9]+/", $pass))) {
                $_SESSION['message'] = "The <b>Password</b> does not contain <b>Numbers</b>.";
                header('Location: resetPassword.php');
                exit();

            }
            if (strlen($pass) < 8) {
                $_SESSION['message'] = "The <b>Password</b> has to be <b> characters long</b>.";
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

    public function picture($target = " ")
    {
        global $conn;
        if (isset($_FILES['picture'])) {
            $target_dir = "pictures/";  // Local directory for storing uploaded files
            $target_file = $target_dir . basename($_FILES["picture"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $kep = pathinfo($target_file, PATHINFO_FILENAME);
            $kep_dir = $imageFileType;
            $kep = $kep . "." . $kep_dir;

            if ($_FILES['picture']["error"] > 0) {
                return $_FILES["picture"]["error"];
            } else {
                if (is_uploaded_file($_FILES['picture']['tmp_name'])) {

                    $file_name = $_FILES['picture']["name"];
                    $file_temp = $_FILES["picture"]["tmp_name"];
                    $file_size = $_FILES["picture"]["size"];
                    $file_type = $_FILES["picture"]["type"];
                    $file_error = $_FILES['picture']["error"];

                    if (!exif_imagetype($file_temp)) {
                        $_SESSION['message'] = "File is not a picture!";
                        $logType = "Picture";
                        $logText = "The file is not in correct format";
                        $logMessage = $_SESSION['message'];

                        $this->errorLogInsert($_SESSION['email'], $logText, $logType, $logMessage);
                        header('location: ' . $target);
                        exit();
                    }
                    $file_size = $file_size / 1024;
                    if ($file_size > 200) {
                        $_SESSION['message'] = "File is too big!";
                        $logType = "Picture";
                        $logText = "The file is bigger than 200KB";
                        $logMessage = $_SESSION['message'];

                        $this->errorLogInsert($_SESSION['email'], $logText, $logType, $logMessage);
                        header('location: ' . $target);
                        exit();
                    }

                    $ext_temp = explode(".", $file_name);
                    $extension = end($ext_temp);

                    if (isset($_POST['alias'])) {
                        $alias = $_POST['alias'];
                    } else {
                        $alias = "";
                    }

                    $new_file_name = Date("YmdHis") . "$alias.$extension";
                    $upload = "$target_dir$new_file_name";

                    if (!is_dir($target_dir)) {
                        mkdir($target_dir, 0777, true); // Create the directory if it doesn't exist
                    }

                    if (!file_exists($upload)) {
                        if (move_uploaded_file($file_temp, $upload)) {
                            $size = getimagesize($upload);
                            var_dump($size);
                            foreach ($size as $key => $value)
                                echo "$key = $value<br>";

                            echo "<img src=\"$upload\" $size[3] alt=\"$file_name\">";
                        } else {
                            echo "<p><b>Error!</b> Failed to move uploaded file.</p>";
                        }
                    } else {
                        echo "<p><b>Error!</b> File with this name already exists!</p>";
                    }
                } else {
                    echo "<p><b>Error!</b> Possible file upload attack!</p>";

                }
                if ($target != "addTable.php" && $target != "modifyMenu.php" && $target != "modifyTable.php" && $target != "addMenu.php") {


                    // Assuming 'profilkep' is a column in your table
                    if ($target == "index.php" || $target == "users.php" || $target == "workers.php" || $target == "tables.php"
                        || $target == "reports.php" || $target == "menu.php") {

                        $query = mysqli_prepare($conn, "UPDATE user SET profilePic = ? WHERE userMail= ?");
                        $query->bind_param("ss", $new_file_name, $_SESSION['email']);
                        $query->execute();
                        $_SESSION['profilePic'] = $new_file_name;
                        // Redirect to login page after successful upload


                        header('Location: ' . $_SESSION['backPic']);
                        exit(); // Exit after redirection
                    }
                   else {
                        $mail = 'Unknown';
                        $logType = "file Upload";
                        $logText = "Someone tried to upload a picture from a not valid page";
                        $logMessage = "You can't upload a picture from another page!";

                        $this->errorLogInsert($mail, $logText, $logType, $logMessage);
                        $_SESSION['message'] = "You can't upload a picture from another page!";
                        header('Location: ' . $_SESSION['backPic']);
                        exit();
                    }
                }

        }
        }
        return $_FILES['picture']["name"];
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
        session_start();

        global $conn;


        if (isset($_POST['mail'], $_POST['pass'])) {
            $mail = $_POST['mail'];
            $password = $_POST['pass'];


            $sql = "SELECT * FROM user WHERE userMail = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $mail);
            $stmt->execute();
            $result = $stmt->get_result();


            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                sleep(2);
                if (empty($row['userPassword'])) {
                    $_SESSION['message'] = "The worker did not set up a password!";
                } else {

                    if (password_verify($password, $row['userPassword'])) {
                        if ($row['banned']) {
                            $_SESSION['message'] = "You have been banned from our website!";
                        } else {

                            $_SESSION['email'] = $row['userMail'];
                            $_SESSION['name'] = $row['firstName'] . " " . $row['lastName'];
                            $_SESSION['profilePic'] = $row['profilePic'];
                            $_SESSION['userID'] = $row['userId'];

                            header('Location: index.php');
                            exit();
                        }
                    } else {
                        $logType = "Log in";
                        $logText = "The password was not valid!";
                        $logMessage = "Wrong password!";

                        $this->errorLogInsert($mail, $logText, $logType, $logMessage);
                        $_SESSION['message'] = "Wrong password!";
                    }
                }
            } else {
                $_SESSION['message'] = "Something went wrong, maybe the mail is not registered!";
                $logType = "Log in";
                $logText = "The E-mal is not in our database";
                $logMessage = $_SESSION['message'];

                $this->errorLogInsert($mail, $logText, $logType, $logMessage);

            }
        } else {
            $_SESSION['message'] = "Email or password not set!";

        }


        header('Location: logIn.php');
        exit();
    }

    public function registration()
    {
        if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['tel1']) && isset($_POST['tel2']) && isset($_POST['mail']) && isset($_POST['pass']) && isset($_POST['pass2'])) {
            global $conn;

            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $tel1 = $_POST['tel1'];

            $tel2 = $_POST['tel2'];
            $tel = $tel1 . "" . $tel2;

            $mail = $_POST['mail'];
            $_SESSION["email"] = $mail;
            $pass = $_POST['pass'];
            $pass2 = $_POST['pass2'];

            $this->userCheck1($fname, $lname, $mail, $tel2, "registration.php");

            $this->passwordCheck($pass, $pass2, "registration.php");

            try {
                // SMTP settings
                $time = time();
                $verifyTime = time() + 60 * 10;
                $verification_time = date("Y-m-d H:i:s", $verifyTime);
                $currentTime = date("Y-m-d H:i:s", $time);

                $sql = "SELECT userMail,verify,verification_time FROM user";
                $stmtTeszt = $conn->query($sql);

                if ($stmtTeszt->num_rows > 0) {
                    while ($rows = $stmtTeszt->fetch_assoc()) {


                        if ($rows['userMail'] == $mail) {
                            if ($rows['verify'] == 1) {
                                $_SESSION['message'] = "The <b>Registration</b> has not been successful! Try again or check if your mail is not registered here";
                                header('Location: registration.php');
                                exit();
                            } else {

                                $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
                                $query = mysqli_prepare($conn, "UPDATE user SET verification_code = ? ,verification_time =? WHERE userMail = ?");
                                $query->bind_param("sss", $verification_code, $verification_time, $mail);
                                $query->execute();
                                $_SESSION['message'] = "If ypu think the<b>E-mail</b> address is registered try again.";
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
                    $banned_time = null;
                    $verification_code_expire = null;
                    $verification_code_pass = null;

                    // Insert user data into the database
                    $sql = "INSERT INTO user (firstName, lastName, phoneNumber, userMail, userPassword,
                  verification_code,verify,profilePic,
                 privilage,registrationTime	,verification_time,banned,banned_time,passwordValidation,passwordValidationTime) 
VALUES (?,?,?,?, ?,? ,?, ?,?, ?,?,?,?,?,?)";
                    $stmt = $conn->prepare($sql);
                    $verrification = 0; // Placeholder for verification_code
                    $stmt->bind_param("ssissiissssisss", $fname, $lname, $tel, $mail, $pass,
                        $verification_code,
                        $verrification, $kep, $privilage, $currentTime, $verification_time,
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
                $_SESSION['message'] = "An error occurred: " . $e->getMessage();
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
            $_SESSION['message'] = "The <b>Password</b> is not filled out";
            header('Location: ' . $location);
            exit();
        }
        if ($password2 == '') {
            $_SESSION['message'] = "The <b>Confirmation Password</b> is not filled out";
            header('Location: ' . $location);
            exit();
        }
        if ($password != $password2) {
            $_SESSION['message'] = "The Passwords do not match";
            header('Location: ' . $location);
            exit();
        }
        if (!(preg_match("/[a-z]/", $password))) {
            $_SESSION['message'] = "The <b>Password</b> does not contain <b>Lower case</b>.";
            header('Location: ' . $location);
            exit();

        }
        if (!(preg_match("/[A-Z]/", $password))) {
            $_SESSION['message'] = "The <b>Password</b> does not contain <b>Upper case</b>.";
            header('Location: ' . $location);
            exit();

        }
        if (!(preg_match("/[0-9]+/", $password))) {
            $_SESSION['message'] = "The <b>Password</b> does not contain <b>Numbers</b>.";
            header('Location: ' . $location);
            exit();

        }
        if (strlen($password) < 8) {
            $_SESSION['message'] = "The <b>Password</b> has to be <b> characters long</b>.";
            header('Location: ' . $location);
            exit();
        }
    }

    public function userCheck1($fname, $lname, $email, $tel2, $location)
    {
        if ($fname == '') {
            $_SESSION['message'] = "The <b>First Name</b> is not filled out";
            header('Location: ' . $location);
            exit();
        }
        if ($lname == '') {
            $_SESSION['message'] = "The <b>Last Name</b> is not filled out";
            header('Location: ' . $location);
            exit();
        }
        if ($email == '') {
            $_SESSION['message'] = "The <b>E-mail</b> is not filled out";
            header('Location: ' . $location);
            exit();
        }
        if (preg_match("/[0-9]+/", $fname)) {
            $_SESSION['message'] = "The <b>First Name</b> filled contains <b>Numbers</b>.";
            header('Location: ' . $location);
            exit();
        }
        if (preg_match("/\s/", $fname)) {
            $_SESSION['message'] = "The <b>First Name</b> filled contains <b>Spaces</b>";
            header('Location: ' . $location);
            exit();
        }
        if (preg_match("/[0-9]+/", $lname)) {
            $_SESSION['message'] = "The <b>Last Name</b> filled contains <b>Numbers</b>";
            header('Location: ' . $location);
            exit();
        }
        if (preg_match("/\s/", $lname)) {
            $_SESSION['message'] = "The <b>Last Name</b> filled contains <b>Spaces</b>";
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
                $_SESSION['message'] = "The <b>Phone Number</b> does not exist!";
                header('Location: ' . $location);
                exit();
            }
        } else {
            $_SESSION['message'] = "The <b>Phone Number</b> is not filled out";
            header('Location: ' . $location);
            exit();
        }

    }

    public function userModifyData($fname, $lname, $tel2, $location)
    {

        if (preg_match("/[0-9]+/", $fname)) {
            $_SESSION['message'] = "The <b>First Name</b> filled contains <b>Numbers</b>.";
            header('Location: ' . $location);
            exit();
        }
        if (preg_match("/\s/", $fname)) {
            $_SESSION['message'] = "The <b>First Name</b> filled contains <b>Spaces</b>";
            header('Location: ' . $location);
            exit();
        }
        if (preg_match("/[0-9]+/", $lname)) {
            $_SESSION['message'] = "The <b>Last Name</b> filled contains <b>Numbers</b>";
            header('Location: ' . $location);
            exit();
        }
        if (preg_match("/\s/", $lname)) {
            $_SESSION['message'] = "The <b>Last Name</b> filled contains <b>Spaces</b>";
            header('Location: ' . $location);
            exit();
        }
        if ($tel2 != "") {
            if (strlen($tel2) != 7) {
                $_SESSION['message'] = "The <b>Phone Number</b> does not exist!";
                header('Location: ' . $location);
                exit();
            }
        }


    }
}

$functions = new Functions();

echo $_SESSION['message'];
?>
