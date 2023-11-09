# Генератор Captcha в формате SVG с кругами
![](./dock/images/captcha-2.png) \
![](./dock/images/captcha-3.png) 
![](./dock/images/captcha-1.png)

## Пример использования

``width`` - ширина экрана \
``height`` - высота экрана \
``maxCountCircles`` - количество кругов

```php
$captcha = new CaptchaSVG(width: 150, height: 350, maxCountCircles: 12);
echo $captcha->create();
```