<?php

namespace Nigo\Captcha;

class ReCaptchaSVG
{
    private int $recaptchaWidth;

    private int $height;

    private int $correlationWidthHeight;

    private int $countElementsOnImage;

    private int $countElementsOnReCaptcha = 6;

    private array $createdElementsOnImage = [];

    private array $createdImages = [];

    public function __construct(int $recaptchaWidth = 250, int $height = 0, int $correlationWidthHeight = 3, int $countElementsOnImage = 2)
    {
        $this->recaptchaWidth = $recaptchaWidth;
        $this->correlationWidthHeight = $correlationWidthHeight;
        $this->countElementsOnImage = $countElementsOnImage;
        $this->height = $height == 0 ? $this->recaptchaWidth / $this->correlationWidthHeight : $height;
    }

    public function create(): string
    {
        for ($i = 0; $i < $this->countElementsOnReCaptcha - 1; $i++) {
            $this->createdImages[] = $this->createImage($i);
        }

        return $this->createBlockReCaptcha();
    }

    public function setStyleForDivReCaptcha(string $style = null, bool $class = false): string
    {
        if (is_null($style)) {
            return "style='display: grid; grid-template-columns: 1fr 1fr 1fr; width: {$this->recaptchaWidth}; grid-gap: 1px'";
        }

        if ($class) {
            return "$class='$style'";
        }

        return $style;
    }

    public function setCorrelationWidthHeight(int $correlationWidthHeight): void
    {
        $this->correlationWidthHeight = $correlationWidthHeight;
    }

    public function setCountElementsOnImage(int $countElementsOnImage): void
    {
        $this->countElementsOnImage = $countElementsOnImage;
    }

    public function setCountElementsOnReCaptcha(int $countElementsOnReCaptcha): void
    {
        $this->countElementsOnReCaptcha = $countElementsOnReCaptcha;
    }

    public function setRecaptchaWidth(int $width): void
    {
        $this->recaptchaWidth = $width;
    }

    private function createBlockReCaptcha(): string
    {
        /** Индекс смещения */
        $displacementIndex = rand(0, count($this->createdImages) - 1);

        /** Индекс картинки */
        $imageIndex = rand(0, count($this->createdImages) - 1);

        array_splice($this->createdImages, $displacementIndex, 0, $this->createdImages[$imageIndex]);

        $block = "<div id='recaptcha' {$this->setStyleForDivReCaptcha()}>";

        $block .= implode(' ', $this->createdImages);

        $block .= '</div>';

        return $block;
    }

    private function createImage(int $id): string
    {
        $svg = "<svg id='$id' height='{$this->height}' width='{$this->getImageWidth()}' style='background: {$this->createBgColor()}; cursor: pointer'>\n";

        for ($i = 0; $i < $this->countElementsOnImage; $i++) {
            $elem = rand(0, 1);

            /** Рандомно выбрать какой элемент отобразить в <svg> */
            switch ($elem) {
                case 0:
                    $this->createRectangle();
                    break;
                case 1:
                    $this->createCircle();
                    break;
                default:
                    break;
            }

            $svg .= implode('', $this->createdElementsOnImage);

        }
        $this->createdElementsOnImage = [];


        return $svg . '</svg>';
    }

    private function createBgColor(): string
    {
        do {
            $red = rand(50, 255);
            $green = rand(50, 255);
            $blue = rand(50, 255);
            $bgColor = "rgba($red, $green, $blue, 0.5)";
        } while ($red == $blue && $red == $green);

        return $bgColor;
    }

    private function createRectangle(): void
    {
        do {
            $cx = rand(10, $this->getImageWidth() - 20);
            $cy = rand(10, $this->getImageWidth() - 20);

            $rectangleWidth = rand(20, 100);
            $rectangleHeight = rand(20, 100);
        } while (
            $cx + $rectangleWidth > $this->getImageWidth() ||
            $cy + $rectangleHeight > $this->height ||
            $cx - $rectangleWidth < 0 ||
            $cy - $rectangleHeight < 0
        );

        $this->createdElementsOnImage[] = "<rect x='$cx' y='$cy' width='$rectangleWidth' height='$rectangleHeight' fill='{$this->createBgColor()}' stroke-width=1 stroke='black'/>\n";
    }

    private function createCircle(): void
    {
        do {
            $radius = rand(10, 100);
            $cx = rand(10, $this->getImageWidth() - 20);
            $cy = rand(10, $this->getImageWidth() - 20);
        } while (
            $cx + $radius > $this->getImageWidth() ||
            $cx - $radius < 0 ||
            $cy + $radius > $this->height ||
            $cy - $radius < 0
        );

        $this->createdElementsOnImage[] = "<circle cx='$cx' cy='$cy' r='$radius' fill='{$this->createBgColor()}' stroke-width=1 stroke='black' />\n";
    }

    private function getImageWidth(): int
    {
        return $this->recaptchaWidth / ($this->countElementsOnReCaptcha / 2);
    }
}