<?php

namespace App\DTO;

/**
 * Frame recording settings response DTO
 */
class FrameRecordingSettingsResponse
{
    public function __construct(
        /** @var int Capture interval in seconds */
        private int $captureIntervalInSeconds,
        
        /** @var string Mode ('available', 'disabled', or 'auto-on') */
        private string $mode,
        
        /** @var string|null Quality of the recording */
        private ?string $quality = null
    ) {}

    public function getCaptureIntervalInSeconds(): int
    {
        return $this->captureIntervalInSeconds;
    }

    public function getMode(): string
    {
        return $this->mode;
    }

    public function getQuality(): ?string
    {
        return $this->quality;
    }

    public function toArray(): array
    {
        $data = [
            'capture_interval_in_seconds' => $this->captureIntervalInSeconds,
            'mode' => $this->mode
        ];
        
        if ($this->quality !== null) {
            $data['quality'] = $this->quality;
        }
        
        return $data;
    }
} 