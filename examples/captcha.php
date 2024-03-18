<?php

require_once '../Captcha/CaptchaSVG.php';

use Nigo\Captcha\CaptchaSVG;

$captcha = new CaptchaSVG();

echo $captcha->create();
echo '<br>';
echo 'Количество кругов: ' . $captcha->getCountCircles();