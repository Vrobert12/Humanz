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
                default:
                    echo "Nope";
            }
        } elseif (isset($_GET['action'])) {
            //Hogyha a fő oldalról jelentkezünk ki akkor get metódust használunk, mivel egy link rákattintásával
            // eltudjuk küldeni az értéket ami szükséges hogy a megfelelő fügvényt elinditsuk
            switch ($_GET['action']) {

                case 'kijelentkezes':
                    $this->logOut();
                    break;

            }
        }
    }

    public function resetPassword()

    {
        global $conn;
        if (isset($_POST['mail']) && isset($_POST['resetPassword']) && isset($_POST['confirmPassword'])) {
            $mail = $_POST['mail'];
            $pass = $_POST['resetPassword'];
            $pass2 = $_POST['confirmPassword'];

            if ($mail == '') {
                $_SESSION['message'] = "Nincsen kitöltve az <b>Email</b> mező";
                header('Location: resetPassword.php');
                exit();
            }

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
                header('Location: logIn.php');
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


            $time = time();
            $expire = date("Y-m-d H:i:s", $time + 60 * 5);
            $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

            $stmt = mysqli_prepare($conn, "UPDATE user SET passwordValidation=?,passwordValidationTime=? where userMail=?");

            $stmt->bind_param("sss", $verification_code, $expire, $mail);
            $_SESSION['verification_code'] = $verification_code;
            if ($stmt->execute()) {
                $_SESSION['email'] = $mail;
                $_SESSION['resetPassword'] = $pass;
                $_SESSION['message'] = "Nezze meg az emailjeit.";
                header('Location: mail.php');
                exit();
            } else {
                $_SESSION['message'] = "Something went wrong.";
                header('Location: resetPassword.php');
                exit();
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

                $query = mysqli_prepare($conn, "UPDATE admin SET profilePic = ? WHERE adminMail = ?");
                $query->bind_param("ss", $new_file_name, $_SESSION['email']);
                $query->execute();
                $query = mysqli_prepare($conn, "UPDATE worker SET profilePic = ? WHERE workerMail = ?");
                $query->bind_param("ss", $new_file_name, $_SESSION['email']);
                $query->execute();
                $query = mysqli_prepare($conn, "UPDATE user SET profilePic = ? WHERE userMail= ?");
                $query->bind_param("ss", $new_file_name, $_SESSION['email']);
                $query->execute();
                $_SESSION['profilePic'] = $new_file_name;
                // Redirect to login page after successful upload


                header('Location: index.php');
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

        $sql = "SELECT * FROM admin";
        $stmt = $conn->query($sql);

        $_SESSION['message'] = "";
        if ($stmt->num_rows > 0) {
            while ($row = $stmt->fetch_assoc()) {
                if ($_POST['mail'] == $row['adminMail']) {
                    session_start();
                    if (password_verify($_POST['pass'], $row['adminPassword'])) {


                        $_SESSION['message'] = "";
                        $_SESSION['email'] = $row['adminMail'];
                        $_SESSION['name'] = $row['firstName'] . " " . $row['lastName'];
                        $_SESSION['profilePic'] = $row['profilePic'];


                        // Store relevant user information in session variables

                        sleep(2);
                        // Redirect the user to the main page
                        header('Location: index.php');
                        exit();
                    } else {
                        $_SESSION['message'] = "Nem jo a <b>jelszó</b>.";
                        sleep(2);
                        header('Location: logIn.php');
                        exit();
                    }
                }
            }
            // If no match found for the email address

        }
        $sql = "SELECT * FROM worker";
        $stmt = $conn->query($sql);

        $_SESSION['message'] = "";
        if ($stmt->num_rows > 0) {
            while ($row = $stmt->fetch_assoc()) {
                if ($_POST['mail'] == $row['workerMail']) {
                    session_start();
                    if (password_verify($_POST['pass'], $row['workerPassword'])) {


                        $_SESSION['message'] = "";
                        $_SESSION['email'] = $row['workerMail'];
                        $_SESSION['name'] = $row['firstName'] . " " . $row['lastName'];
                        $_SESSION['profilePic'] = $row['profilePic'];


                        // Store relevant user information in session variables


                        // Redirect the user to the main page
                        sleep(2);
                        header('Location:index.php');
                        exit();
                    } else {sleep(2);
                        $_SESSION['message'] = "Nem jo a <b>jelszó</b>.";
                        header('Location: logIn.php');
                        exit();
                    }
                }
            }
            // If no match found for the email address

        }
        $sql = "SELECT * FROM user";
        $stmt = $conn->query($sql);

        $_SESSION['message'] = "";
        if ($stmt->num_rows > 0) {
            while ($row = $stmt->fetch_assoc()) {
                if ($_POST['mail'] == $row['userMail']) {
                    session_start();
                    if (password_verify($_POST['pass'], $row['userPassword'])) {


                        $_SESSION['message'] = "";
                        $_SESSION['email'] = $row['userMail'];
                        $_SESSION['name'] = $row['firstName'] . " " . $row['lastName'];
                        $_SESSION['profilePic'] = $row['profilePic'];


                        // Store relevant user information in session variables


                        // Redirect the user to the main page

                        header('Location:  index.php');sleep(2);
                        exit();
                    } else {sleep(2);
                        $_SESSION['message'] = "Nem jo a <b>jelszó</b>.";
                        header('Location: logIn.php');
                        exit();
                    }
                }
            }
            // If no match found for the email address
            $_SESSION['message'] = "Nincsen ilyen <b>Email</b> cim regisztralva.";
            header('Location: logIn.php');
            exit();
        } else {
            // If no users found in the database
            $_SESSION['message'] = "Nincsenek felhasználók.";
            header('Location: logIn.php');
            exit();
        }
    }


    public function registration()
    {

        global $conn;

        if (isset($_POST['knev']) && isset($_POST['vnev']) && isset($_POST['tel1']) && isset($_POST['tel2']) && isset($_POST['mail']) && isset($_POST['pass']) && isset($_POST['pass2'])) {
            $knev = $_POST['knev'];
            $vnev = $_POST['vnev'];
            $tel1 = $_POST['tel1'];

            $tel2 = $_POST['tel2'];
            $tel = "" . $tel1 . "" . $tel2;

            $mail = $_POST['mail'];
            $_SESSION["email"] = $mail;
            $pass = $_POST['pass'];
            $pass2 = $_POST['pass2'];


            if ($knev == '') {
                $_SESSION['message'] = "Nincsen kitöltve a <b>Keresztnév</b> mező";
                header('Location: registration.php');
                exit();
            }
            if (preg_match("/[0-9]+/", $knev)) {
                $_SESSION['message'] = "A <b>Keresztnév</b> mező tartalmaz számot";
                header('Location: registration.php');
                exit();
            }
            if (preg_match("/\s/", $knev)) {
                $_SESSION['message'] = "A <b>Keresztnév</b> mező tartalmaz üres helyet";
                header('Location: registration.php');
                exit();
            }
            if ($vnev == '') {
                $_SESSION['message'] = "Nincsen kitöltve a <b>Vezetéknév</b> mező";
                header('Location: registration.php');
                exit();
            }

            if (preg_match("/[0-9]+/", $vnev)) {
                $_SESSION['message'] = "A <b>Vezetéknév</b> mező tartalmaz számot";
                header('Location: registration.php');
                exit();
            }
            if (preg_match("/\s/", $vnev)) {
                $_SESSION['message'] = "A <b>Vezetéknév</b> mező tartalmaz üres helyet";
                header('Location: registration.php');
                exit();
            }
            if ($tel == '') {
                $_SESSION['message'] = "Nincsen kitöltve a <b>Telefonszám</b> mező";
                header('Location: registration.php');
                exit();
            }
            if (strlen($tel2) != 7) {
                $_SESSION['message'] = "A <b>Telefonszám</b> nem létezik";
                header('Location: registration.php');
                exit();
            }

            //Ellenőrizzük hogy ez az Email létezhet-e
            if (filter_var($mail, FILTER_VALIDATE_EMAIL) === FALSE) {
                $_SESSION['message'] = "Az <b>eMail</b> nem jó formátumú";
                header('Location: registration.php');
            }
            if ($mail == '') {
                $_SESSION['message'] = "Nincsen kitöltve az <b>Email</b> mező";
                header('Location: registration.php');
                exit();
            }

            if ($pass == '') {
                $_SESSION['message'] = "Nincsen kitöltve a <b>Jelszó</b> mező";
                header('Location: registration.php');
                exit();
            }
            if ($pass2 == '') {
                $_SESSION['message'] = "Nincsen kitöltve a <b>Jelszóbiztosítása</b> mező";
                header('Location: registration.php');
                exit();
            }
            if ($pass != $pass2) {
                $_SESSION['message'] = "Nem eggyezik a jelszó";
                header('Location: registration.php');
                exit();
            }
            if (!(preg_match("/[a-z]/", $pass))) {
                $_SESSION['message'] = "Nincsen <b>kisbetű</b> a jelszóban";
                header('Location: registration.php?message=' . urlencode(""));
                exit();

            }
            if (!(preg_match("/[A-Z]/", $pass))) {
                $_SESSION['message'] = "Nincsen <b>nagybetű</b> a jelszóban";
                header('Location: registration.php');
                exit();

            }
            if (!(preg_match("/[0-9]+/", $pass))) {
                $_SESSION['message'] = "Nem tartalmaz <b>számokat</b> a jelszó";
                header('Location: registration.php');
                exit();

            }
            if (strlen($pass) < 8) {
                $_SESSION['message'] = "A jelszó legalább<b> 8 karaktert</b> kell hogy tartalmazzon";
                header('Location: registration.php');
                exit();
            }

            try {
                // SMTP settings
                $time = time() + 60 * 10;
                $verification_time = date("Y-m-d H:i:s", $time);

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

                    $banned_time = 0;
                    $verification_code_expire = 0;
                    $verification_code_pass = 0;

                    // Insert user data into the database
                    $sql = "INSERT INTO user (firstName, lastName, phoneNumber, userMail, userPassword, verification_code,verify,profilePic,
                  verification_time,banned,banned_time,passwordValidation,passwordValidationTime) VALUES (?,?,?,?, ?, ?, ?,?, ?,?,?,?,?)";
                    $stmt = $conn->prepare($sql);
                    $verrification = 0; // Placeholder for verification_code
                    $stmt->bind_param("ssissiississs", $knev, $vnev, $tel, $mail, $pass, $verification_code,
                        $verrification, $kep, $verification_time, $banned, $banned_time, $verification_code_pass, $verification_code_expire);

                    if ($stmt->execute()) {
                        $_SESSION['message'] = "We sent an email to you!";

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
}
$registration = new Functions();

?>
