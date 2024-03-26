<?php
include 'connection.php';
global $conn;

    if(isset( $_SESSION['message'])){
        echo"<b>".$_SESSION['message']."</b>";}
if(isset($_POST['verify_email'])) {

    $email = $_POST['email'];
    $verification_code = $_POST['verification_code'];

    $sql = "UPDATE regisztralo SET 	verify = 1 WHERE regisztraloEmail = ? AND verification_code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $email, $verification_code);

    if ($stmt->execute()) {
        $_SESSION['message']="Most már be bír jelentekezni";
        header('Location: logIn.php' );

$sqlTeszt="select * from regisztralo";
$stmtTeszt=$conn->query($sqlTeszt);
if($stmtTeszt->num_rows>0){
    while($rows=$stmtTeszt->fetch_assoc()){


    }}

        exit();
    } else {
        echo "Verification failed";
    }
}
?>
<form method="post">
    <input type="hidden" name="email" value="<?php  if(isset( $_SESSION['message'])) echo htmlspecialchars($_SESSION['email']); ?>" required>
    <input type="text" name="verification_code" placeholder="Enter verification code" required>
    <input type="submit" name="verify_email" value="Verify Email">
</form>