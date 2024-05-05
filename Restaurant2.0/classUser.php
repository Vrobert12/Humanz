<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="main.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>


</head>
<body>

<?php


class User
{
    public function __construct($rank,$mail,$previousPage)
    {

        $this->previousPage = $previousPage;
        $this->mail = $mail;
        $this->rank=$rank;

    }

    public function userString()
    {
        global $conn;

        if($this->mail){
            $sql = mysqli_prepare($conn,  "SELECT * FROM user where privilage =? and userMail=?");
            $sql->bind_param("ss", $this->rank,$this->mail);
        }
else{
    $sql = mysqli_prepare($conn,  "SELECT * FROM user where privilage =?");
    $sql->bind_param("s", $this->rank);
}
        $sql->execute();
        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            $_SESSION['previousPage'] =  $this->previousPage;
            echo '<div class="container">
  <div class="row justify-content-around" >';
            while ($row = $result->fetch_assoc()) {
                echo ' <div class="col-xl-4 p-3 border bg-dark" style="  
 margin: auto; margin-top:100px; margin-bottom: 50px;left:0; right:0; width: fit-content">';
                echo "<div class=\"col-xl-4 \"><img class=\"profilePic\" 
src=\"http://localhost:/Restaurant2.0/pictures/" . $row['profilePic'] . "
          \" width=\"250\" height=\"250\" alt=\"profilkep\"></div><label>ID: " . $row['userId'] . "</label><br>
          
<label>Keresztnév: " . $row['firstName'] . "</label><br>
<label>Vezetéknév: " . $row['lastName'] . "</label><br>
<label>Telefonszam: " . $row['phoneNumber'] . "</label><br>

<label>Email cím: " . $row['userMail'] . "</label><br>";
                $_SESSION['chosenName']= $row['firstName']." ".$row['lastName'];
                if ($row['verify'] == 1) {
                    echo '<label style="color: green; font-size: 20px">Verified</label><br>';
                } else
                    echo '<label style="color: red; font-size: 20px">Not verified</label><br>';
                    echo'';
                if ($row['banned'] == 0) {
                    echo '
<form  method="post" action="functions.php">
<label style="color: green; font-size: 20px">Legit User</label><br>
<input type="hidden" name="id" value=' . $row['userId'] . ' >
                <input type="hidden" name="ban" value= "no" >
    <input type="submit" id="banForm" name="action" value="BanPerson" onclick="banUser('.$row['firstName']." ".$row['lastName'].')"></form>';

                    $_SESSION['isBanned'] = false;
                } else {
                    echo "<label style='color: red; font-size: 20px'>Banned</label><br>
<label> Ban time: " . $row['banned_time'] . "</label><br>";

                    echo '<form id="banForm" method="post" action="functions.php">
            <input type="hidden" name="id" value=' . $row['userId'] . ' >    
            <input type="hidden" name="ban" value="yes" >
    <input type="submit" id="banForm" name="action" value="UnBanPerson" onclick="banUser('.$row['firstName']." ".$row['lastName'].')"></form>
    ';
                    $_SESSION['isBanned'] = true;
                }
               echo "<label>Rank: " . $row['privilage'] . "</label><br>
<label>Registration time: " . $row['registrationTime'] . "</label><br></div>";
            }
        }
    }
}
echo"</div></div>";

?>
<script>
    function banUser(name) {
        if (confirm("Are you sure about banning " + name + "?")) {
            document.getElementById("banForm").submit();
        } else {
            console.log("Ban action canceled.");
        }
    }
</script>
</body>
