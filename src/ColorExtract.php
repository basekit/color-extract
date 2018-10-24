<?php namespace ColorExtract;

use League\ColorExtractor\Color;
use League\ColorExtractor\ColorExtractor;
use League\ColorExtractor\Palette;
use Monolog\Logger;

class ColorExtract
{
    public function extract($path)
    {
        $image = $this->assetToResource($path);
        $dominantColor = $this->getDominantColor($image);
        return $dominantColor;
    }

    private function loadAsset($file)
    {
        $params = [
            'http' => [
                'user_agent' => 'PHP',
            ],
        ];

        $context = stream_context_create($params);
        return @file_get_contents($file, false, $context);
    }

    private function assetToResource($file)
    {
        return imagecreatefromstring($this->loadAsset($file));
    }

    private function getDominantColor($assetResource)
    {
        $colorExtractor = new ColorExtractor(Palette::fromGD($assetResource));
        $dominantColor = Color::fromIntToHex(current($colorExtractor->extract(1)));
        return $dominantColor;
    }
}