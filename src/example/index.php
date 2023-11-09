<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<?php



require_once 'vendor/autoload.php';

use Nigo\Captcha\CaptchaSVG;

$captcha = new CaptchaSVG(width: 150, height: 350, maxCountCircles: 12);
echo $captcha->create();

?>


</body>
</html>