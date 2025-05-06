<?php

namespace App\DTO;

/**
 * Record settings response DTO
 */
class RecordSettingsResponse
{
    public function __construct(
        /** @var bool Whether audio only recording is enabled */
        private bool $audioOnly,
        
        /** @var string Recording mode */
        private string $mode,
        
        /** @var string Recording quality */
        private string $quality,
        
        /** @var LayoutSettingsResponse Layout settings */
        private LayoutSettingsResponse $layout
    ) {}

    public function getAudioOnly(): bool
    {
        return $this->audioOnly;
    }

    public function getMode(): string
    {
        return $this->mode;
    }

    public function getQuality(): string
    {
        return $this->quality;
    }

    public function getLayout(): LayoutSettingsResponse
    {
        return $this->layout;
    }

    public function toArray(): array
    {
        return [
            'audio_only' => $this->audioOnly,
            'mode' => $this->mode,
            'quality' => $this->quality,
            'layout' => $this->layout->toArray()
        ];
    }
} 