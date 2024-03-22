<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'C:/Users/varro/vendor/autoload.php';
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
                case 'bejelentkezes':
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
            $target_dir = "C:/xampp/xampp/htdocs/Restaurant/pictures/";
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
        $sql = "SELECT * FROM regisztralo";
        $stmt = $conn->query($sql);


        if ($stmt->num_rows > 0) {
            while ($row = $stmt->fetch_assoc()) {
                if ($_POST['mail'] == $row['regisztraloEmail']) {

                    if (password_verify($_POST['pass'], $row['regisztraloJelszo'])) {
                        if($_POST['verify']==0){
                            header('Location: logIn.php?message=' . urlencode("Nincs verifikalva az account"));
                        }

                        session_start();

                        // Store relevant user information in session variables
                        $_SESSION['email'] = $row['regisztraloEmail'];
                        $_SESSION['name'] = $row['keresztnev'] . " " . $row['vezeteknev'];
                        $_SESSION['profilePic'] = $row['profilkep'];

                        // Redirect the user to the main page
                        header('Location: MainPage.php?status=Logged');
                        exit();
                    } else {
                        header('Location: logIn.php?message=' . urlencode("Nem jo a jelszo"));
                        exit();
                    }
                }
            }
            // If no match found for the email address
            header('Location: logIn.php?message=' . urlencode("Nincsen ilyen Email cim regisztralva."));
            exit();
        } else {
            // If no users found in the database
            header('Location: logIn.php?message=' . urlencode("Nincsenek felhasználók."));
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
            $pass = $_POST['pass'];
            $pass2 = $_POST['pass2'];
            $mailToken = new PHPMailer(true);

            if ($knev == '') {
                header('Location: registration.php?message=' . urlencode("Nincsen kitöltve a <b>Keresztnév</b> mező"));
                exit();
            }
            if (preg_match("/[0-9]+/", $knev)) {
                header('Location: registration.php?message=' . urlencode("A <b>Keresztnév</b> mező tartalmaz számot"));
                exit();
            }
            if (preg_match("/\s/", $knev)) {
                header('Location: registration.php?message=' . urlencode("A <b>Keresztnév</b> mező tartalmaz üres helyet"));
                exit();
            }
            if ($vnev == '') {
                header('Location: registration.php?message=' . urlencode("Nincsen kitöltve a <b>Vezetéknév</b> mező"));
                exit();
            }

            if (preg_match("/[0-9]+/", $vnev)) {
                header('Location: registration.php?message=' . urlencode("A <b>Vezetéknév</b> mező tartalmaz számot"));
                exit();
            }
            if (preg_match("/\s/", $vnev)) {
                header('Location: registration.php?message=' . urlencode("A <b>Vezetéknév</b> mező tartalmaz üres helyet"));
                exit();
            }
            if ($tel == '') {
                header('Location: registration.php?message=' . urlencode("Nincsen kitöltve a <b>Telefonszám</b> mező"));
                exit();
            }
            if (strlen($tel2) != 7) {
                header('Location: registration.php?message=' . urlencode("A <b>Telefonszám</b> nem létezik"));
                exit();
            }

            //Ellenőrizzük hogy ez az Email létezhet-e
            if (filter_var($mail, FILTER_VALIDATE_EMAIL) === FALSE) {
                header('Location: registration.php?message=' . urlencode("Az <b>eMail</b> nem jó formátumú"));
            }
            if ($mail == '') {
                header('Location: registration.php?message=' . urlencode("Nincsen kitöltve az <b>Email</b> mező"));
                exit();
            }


            if ($pass == '') {
                header('Location: registration.php?message=' . urlencode("Nincsen kitöltve a <b>Jelszó</b> mező"));
                exit();
            }
            if ($pass2 == '') {
                header('Location: registration.php?message=' . urlencode("Nincsen kitöltve a <b>Jelszóbiztosítása</b> mező"));
                exit();
            }
            if ($pass != $pass2) {
                header('Location: registration.php?message=' . urlencode("Nem eggyezik a jelszó"));
                exit();
            }
            if (!(preg_match("/[a-z]/", $pass))) {
                header('Location: registration.php?message=' . urlencode("Nincsen <b>kisbetű</b> a jelszóban"));
                exit();

            }
            if (!(preg_match("/[A-Z]/", $pass))) {
                header('Location: registration.php?message=' . urlencode("Nincsen <b>nagybetű</b> a jelszóban"));
                exit();

            }
            if (!(preg_match("/[0-9]+/", $pass))) {
                header('Location: registration.php?message=' . urlencode("Nem tartalmaz <b>számokat</b> a jelszó"));
                exit();

            }
            if (strlen($pass) < 8) {
                header('Location: registration.php?message=' . urlencode("A jelszó legalább<b> 8 karaktert</b> kell hogy tartalmazzon"));
                exit();
            }

            try {
                // SMTP settings
                $mailToken->SMTPDebug = 0;
                $mailToken->isSMTP();
                $mailToken->Host = 'smtp.gmail.com';
                $mailToken->SMTPAuth = true;
                $mailToken->Username = 'robertvarro12@gmail.com'; // Your Gmail email
                $mailToken->Password = 'ccxcegdrwuvxwjpo'; // Your Gmail password
                $mailToken->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mailToken->Port = 465;
                $mailToken->setFrom('robertvarro12@gmail.com', 'Humanz'); // Sender's email and name
                $mailToken->addAddress($mail, $knev); // Recipient's email and name
                $mailToken->isHTML(true);

                // Generate verification code
                $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

                // Email content
                $mailToken->Subject = 'Email verification';
                $mailToken->Body = '<h1>Na ki csinálta meg az email verifikációt</h1><br><h3> Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></h3>';


                $sqlTeszt="select * from regisztralo";
                $stmtTeszt=$conn->query($sqlTeszt);
                if($stmtTeszt->num_rows>0){
                    while($rows=$stmtTeszt->fetch_assoc()){
                        if($rows['regisztraloEmail']==$mail){
                            header('Location: registration.php?message=' . urlencode("Az <b>e-mail</b> cím már regisztrálva van"));
                            if($rows['verify']==0){
                                $verification_code=$rows['verification_code'];
                                $mailToken->Subject = 'Email verification';
                                $mailToken->Body = '<h1>Újra küldtük a kódot</h1><br><h3> Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></h3>';
                                header('Location: email-verification.php?email=' . $mail.'&message=' . urlencode("Az<b>e-mail</b> cím már regisztrálva van,de nincs hitelesitve, elküldtük az emailre a hitelesitő kódot"));
                                $mailToken->send();
                                exit();
                            }
                            else{
                                exit();
                            }
                        }

                    }
                }

                // Send email
                if ($mailToken->send()) {
                    // Hash the password
                    $pass = password_hash($pass, PASSWORD_BCRYPT);

                    // Insert user data into the database
                    $sql = "INSERT INTO regisztralo (keresztnev, vezeteknev, telefonszam, regisztraloEmail, regisztraloJelszo, verification_code,verify) VALUES (?, ?, ?, ?, ?,?, ?)";
                    $stmt = $conn->prepare($sql);
                    $verrification = 0; // Placeholder for verification_code
                    $stmt->bind_param("ssissii", $knev, $vnev, $tel, $mail, $pass, $verification_code, $verrification );

                    if ($stmt->execute()) {
                        header('Location: email-verification.php?email=' . $mail);
                        exit(); // Exit script after redirection
                    } else {
                        echo "Error occurred during registration: " . $conn->error;
                    }
                } else {
                    echo "Message could not be sent. Mailer Error: {$mailToken->ErrorInfo}";
                }
            } catch (Exception $e) {
                echo "An error occurred: " . $e->getMessage();
            }
        }


    }

}

$registration = new Functions();

?>
