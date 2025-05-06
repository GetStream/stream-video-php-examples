<?php

namespace App\DTO;

/**
 * Target resolution DTO
 */
class TargetResolution
{
    public function __construct(
        /** @var int Bitrate */
        private int $bitrate,
        
        /** @var int Height */
        private int $height,
        
        /** @var int Width */
        private int $width
    ) {}

    public function getBitrate(): int
    {
        return $this->bitrate;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function toArray(): array
    {
        return [
            'bitrate' => $this->bitrate,
            'height' => $this->height,
            'width' => $this->width
        ];
    }
} 