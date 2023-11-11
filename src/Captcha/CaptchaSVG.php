<?php

namespace Nigo\Captcha;

class CaptchaSVG
{
    private int $countCircles;

    private int $width;

    private int $height;

    private array $circlesRadius = [];

    private int $maxCountCircles;

    public function __construct(int $width = 200, int $height = 200, int $maxCountCircles = 8)
    {
        $this->maxCountCircles = $maxCountCircles;
        $this->width = $width;
        $this->height = $height;
        $this->countCircles = rand(1, $this->maxCountCircles);
    }

    public function create(): string
    {
        $svg = "<svg height='{$this->height}' width='{$this->width}' style='background: darkgray'>\n";

        $svg .= $this->createCircles();

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

    private function createCircles(): string
    {
        $circles = '';

        for ($i = 0; $i < $this->countCircles; $i++) {

            do {
                $radius = rand(10, 100);
                $cx = rand(10, $this->width - 20);
                $cy = rand(10, $this->height - 20);
            } while ($this->checkDiameterInArray($radius) || $cx + $radius > $this->width || $cx - $radius < 0 || $cy + $radius > $this->height || $cy - $radius < 0);

            $this->circlesRadius[] = $radius;

            $circles .= "<circle cx='$cx' cy='$cy' r='$radius' fill='{$this->createBgColor()}' stroke-width=1 stroke='black' />\n";
        }

        return $circles;
    }

    private function checkDiameterInArray(int $radius): bool
    {
        return in_array($radius, $this->circlesRadius);
    }

    public function getCountCircles(): int
    {
        return $this->countCircles;
    }
}