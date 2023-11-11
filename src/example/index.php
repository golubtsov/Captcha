<?php

require_once 'vendor/autoload.php';

use Nigo\Captcha\CaptchaSVG;

$captcha = new CaptchaSVG();

echo $captcha->create();
echo '<br>';
echo 'Количество кругов: ' . $captcha->getCountCircles();