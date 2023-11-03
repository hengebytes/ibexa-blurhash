<?php

namespace HengeBytes\IbexaBlurhashBundle\Service;

use Intervention\Image\ImageManager;
use kornrunner\Blurhash\Blurhash as BlurhashEncoder;

class BlurhashGeneratorService
{
    public function __construct(
        private readonly ImageManager $imageManager,
        private readonly int $encodeWidth,
        private readonly int $encodeHeight
    ) {
    }

    public function encode(string $filename): string
    {
        // Resize image to increase encoding performance
        $image = $this->imageManager->make(file_get_contents($filename));
        $image->resize($this->encodeWidth, $this->encodeHeight, static function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        // Encode using BlurHash
        $width = $image->getWidth();
        $height = $image->getHeight();

        $pixels = [];
        for ($y = 0; $y < $height; ++$y) {
            $row = [];
            for ($x = 0; $x < $width; ++$x) {
                $color = $image->pickColor($x, $y);
                $row[] = [$color[0], $color[1], $color[2]];
            }

            $pixels[] = $row;
        }

        return BlurhashEncoder::encode($pixels, 4, 3);
    }
}