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

    public function picture()
    {
        global $conn;
        if (isset($_FILES['picture'])) {
            $target_dir = "C:/xampp/xampp/htdocs/Restaurant2.0/Restaurant/pictures/";
            $target_file = $target_dir . basename($_FILES["picture"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $kep = pathinfo($target_file, PATHINFO_FILENAME);
            $kep_dir = $imageFileType;
            $kep = $kep . "." . $kep_dir;

            // Assuming 'profilkep' is a column in your table
            $query = mysqli_prepare($conn, "UPDATE regisztralo SET profilkep = ? WHERE regisztraloEmail = ?");
            $query->bind_param("ss", $kep, $_SESSION['email']);
            $query->execute();
            $_SESSION['profilePic'] = $kep;
            // Redirect to login page after successful upload
            header('Location: MainPage.php');
            exit(); // Exit after redirection
        }
    }

    public function logOut()
    {

        $_SESSION = [];
        session_unset();
        session_destroy();

        // Redirect to login page
        header('Location: MainPage.php');
        exit();
    }

    public function login()
    {
        global $conn;
        $sql = "SELECT * FROM rendszergazda";
        $stmt = $conn->query($sql);

        $_SESSION['message'] = "";
        if ($stmt->num_rows > 0) {
            while ($row = $stmt->fetch_assoc()) {
                if ($_POST['mail'] == $row['rendszerGazdaEmail']) {
                    session_start();
                    if (password_verify($_POST['pass'], $row['rendszerGazdaJelszo'])) {


                        $_SESSION['message'] = "";
                        $_SESSION['email'] = $row['rendszerGazdaEmail'];
                        $_SESSION['name'] = $row['keresztnev'] . " " . $row['vezeteknev'];
                        $_SESSION['profilePic'] = $row['profilkep'];
                        $_SESSION['privilege'] = $row['jogosultsag'];

                        // Store relevant user information in session variables


                        // Redirect the user to the main page
                        header('Location: MainPage.php');
                        exit();
                    } else {
                        $_SESSION['message'] = "Nem jo a <b>jelszó</b>.";
                        header('Location: logIn.php');
                        exit();
                    }
                }
                $sql = "SELECT * FROM rendszergazda";
                $stmt = $conn->query($sql);

                $_SESSION['message'] = "";
                if ($stmt->num_rows > 0) {
                    while ($row = $stmt->fetch_assoc()) {
                        if ($_POST['mail'] == $row['rendszerGazdaEmail']) {
                            session_start();
                            if (password_verify($_POST['pass'], $row['rendszerGazdaJelszo'])) {


                                $_SESSION['message'] = "";
                                $_SESSION['email'] = $row['rendszerGazdaEmail'];
                                $_SESSION['name'] = $row['keresztnev'] . " " . $row['vezeteknev'];
                                $_SESSION['profilePic'] = $row['profilkep'];


                                // Store relevant user information in session variables


                                // Redirect the user to the main page
                                header('Location: MainPage.php');
                                exit();
                            } else {
                                $_SESSION['message'] = "Nem jo a <b>jelszó</b>.";
                                header('Location: logIn.php');
                                exit();
                            }
                        }
                    }
                    // If no match found for the email address

                }
                $sql = "SELECT * FROM dolgozo";
                $stmt = $conn->query($sql);

                $_SESSION['message'] = "";
                if ($stmt->num_rows > 0) {
                    while ($row = $stmt->fetch_assoc()) {
                        if ($_POST['mail'] == $row['dolgozoEmail']) {
                            session_start();
                            if (password_verify($_POST['pass'], $row['dolgozoJelszo'])) {


                                $_SESSION['message'] = "";
                                $_SESSION['email'] = $row['dolgozoEmail'];
                                $_SESSION['name'] = $row['keresztnev'] . " " . $row['vezeteknev'];
                                $_SESSION['profilePic'] = $row['profilkep'];
                                $_SESSION['privilege'] = $row['jogosultsag'];

                                // Store relevant user information in session variables


                                // Redirect the user to the main page
                                header('Location: MainPage.php');
                                exit();
                            } else {
                                $_SESSION['message'] = "Nem jo a <b>jelszó</b>.";
                                header('Location: logIn.php');
                                exit();
                            }
                        }
                    }
                    // If no match found for the email address

                }
                $sql = "SELECT * FROM regisztralo";
                $stmt = $conn->query($sql);

                $_SESSION['message'] = "";
                if ($stmt->num_rows > 0) {
                    while ($row = $stmt->fetch_assoc()) {
                        if ($_POST['mail'] == $row['regisztraloEmail']) {
                            session_start();
                            if (password_verify($_POST['pass'], $row['regisztraloJelszo'])) {


                                $_SESSION['message'] = "";
                                $_SESSION['email'] = $row['regisztraloEmail'];
                                $_SESSION['name'] = $row['keresztnev'] . " " . $row['vezeteknev'];
                                $_SESSION['profilePic'] = $row['profilkep'];
                                $_SESSION['privilege'] = $row['jogosultsag'];

                                // Store relevant user information in session variables


                                // Redirect the user to the main page
                                header('Location: MainPage.php');
                                exit();
                            } else {
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


                $sqlTeszt = "select * from regisztralo";
                $stmtTeszt = $conn->query($sqlTeszt);
                if ($stmtTeszt->num_rows > 0) {
                    while ($rows = $stmtTeszt->fetch_assoc()) {
                        if ($rows['regisztraloEmail'] == $mail) {
                            header('Location: registration.php?message=' . urlencode("Az<b>E-mail</b> cím már regisztrálva van"));

                            $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
                            $query = mysqli_prepare($conn, "UPDATE regisztralo SET verification_code = ? WHERE regisztraloEmail = ?");
                            $query->bind_param("ss", $verification_code, $mail);
                            $query->execute();
                            header('Location: email-verification.php?email=' . $mail . '&message=' . urlencode("Az<b>E-mail</b> cím már regisztrálva van,de nincs hitelesitve, elküldtük az emailre a hitelesitő kódot"));

                            exit();

                        }

                    }
                }


                $kep = "logInPic.jpg";


                // Send email

                // Hash the password
                $pass = password_hash($pass, PASSWORD_BCRYPT);
                $jogosultsag = "Felhasznalo";

                // Insert user data into the database
                $sql = "INSERT INTO regisztralo (keresztnev, vezeteknev, telefonszam, regisztraloEmail, regisztraloJelszo, verification_code,verify,profilkep,jogosultsag) VALUES (?,?, ?, ?, ?, ?,?, ?,?)";
                $stmt = $conn->prepare($sql);
                $verrification = 0; // Placeholder for verification_code
                $stmt->bind_param("ssissiiss", $knev, $vnev, $tel, $mail, $pass, $verification_code, $verrification, $kep, $jogosultsag);

                if ($stmt->execute()) {
                    header('Location: logIn.php?email=' . $mail);
                    exit(); // Exit script after redirection
                } else {
                    echo "Error occurred during registration: " . $conn->error;
                }

            } catch (Exception $e) {
                echo "An error occurred: " . $e->getMessage();
            }
        }

    }

}

$registration = new Functions();

?>
