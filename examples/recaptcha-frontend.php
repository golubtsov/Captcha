<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ReCaptcha</title>
</head>
<body>

<div>
    <?php

    require_once '../Captcha/ReCaptchaSVG.php';

    use Nigo\Captcha\ReCaptchaSVG;

    $recaptcha = new ReCaptchaSVG();

    echo $recaptcha->create();

    ?>
</div>

<script>
    const indexesRepeatImages = <?php echo json_encode($recaptcha->getIndexesRepeatImages()) ?> ;

    const recaptchaElems = document.querySelectorAll('#recaptcha svg');

    let imagesFormRecaptcha = [];

    const getIndex = (index) => {
        if (imagesFormRecaptcha.length !== 2) {
            imagesFormRecaptcha.push(index);
        }

        if (imagesFormRecaptcha.length === 2) {
            imagesFormRecaptcha.includes(indexesRepeatImages[0]) && imagesFormRecaptcha.includes(indexesRepeatImages[1]) ? alert('Картинки выбраны правильно') : alert('Попробуйте еше раз');
            imagesFormRecaptcha = [];
        }
    }

    recaptchaElems.forEach((el, index) => {
        el.addEventListener('click', () => getIndex(index));
    });
</script>

</body>
</html>
