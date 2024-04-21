<?php
date_default_timezone_set('Europe/Budapest');

if (ini_get('date.timezone')) {
    echo 'date.timezone: ' . ini_get('date.timezone') . '<br>';
}

/*

https://www.php.net/manual/en/function.setcookie.php
https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie/SameSite

 ctrl+shift+i storage

 */
echo time();
setcookie("language", "english", time() + 3600);
setcookie("language_login", "english", time() + 60 * 60 * 24 * 30);
setcookie("TestCookie0", "value", time() - 3600);
setcookie("test", "yes", time() + 120);
setcookie("TestCookie", "something", strtotime('+30 days'));
setcookie("cookie['one']", "1", time() + 120);
setcookie("cookie['two']", "2", time() + 120);
setcookie("cookie['three']", "3", time() + 120);
setcookie("secure1", "OK", time() + 120, "/", "", 0, 1);
setcookie("secure2", "OK", time() + 120, "/", "", 1, 1);

/*if(count($_COOKIE) > 0) {
    echo "Cookies are enabled.";
} else {
    echo "Cookies are disabled.";
}
*/


$arr_cookie_options = [
    'expires' => time() + 60 * 60 * 24 * 30,
    'path' => '/',
    'secure' => true,     // or false
    'httponly' => true,    // or false
    'samesite' => 'None' // None || Lax  || Strict
];

//$arr_cookie_options = [
//    'expires' => time() + 60 * 60 * 24 * 30,
//    'path' => '/',
//    'domain' => '.example.com', // leading dot for compatibility or use subdomain
//    'secure' => true,     // or false
//    'httponly' => true,    // or false
//    'samesite' => 'None' // None || Lax  || Strict
//];

setcookie('TestCookieArray', 'The Cookie Value', $arr_cookie_options);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>COOKIE</title>
</head>
<body>
<?php
if (isset($_COOKIE['language']))
    echo "1. cookie - " . $_COOKIE['language'] . "<br>";

if (isset($_COOKIE['TestCookie']))
    echo "2. cookie - " . $_COOKIE['TestCookie'] . "<br>";

echo "<hr>";

var_dump($_COOKIE);
unset($_COOKIE["language"]);
var_dump($_COOKIE);
unset($_COOKIE);
?>
</body>
</html>