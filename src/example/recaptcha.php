<?php

require_once '../Captcha/ReCaptchaSVG.php';

use Nigo\Captcha\ReCaptchaSVG;

$recaptcha = new ReCaptchaSVG();

echo $recaptcha->create();