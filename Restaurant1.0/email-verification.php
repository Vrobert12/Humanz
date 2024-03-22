<?php
include 'connection.php';
global $conn;
if(isset($_GET['message']))
echo'<p>'.$_GET['message'].'</p>';
if(isset($_POST['verify_email'])) {

    $email = $_POST['email'];
    $verification_code = $_POST['verification_code'];

    $sql = "UPDATE regisztralo SET 	verify = 1 WHERE regisztraloEmail = ? AND verification_code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $email, $verification_code);

    if ($stmt->execute()) {
        header('Location: logIn.php?message=Most már be bír jelentekezni' );
        exit();
    } else {
        echo "Verification failed";
    }
}
?>
<form method="post">
    <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>" required>
    <input type="text" name="verification_code" placeholder="Enter verification code" required>
    <input type="submit" name="verify_email" value="Verify Email">
</form>