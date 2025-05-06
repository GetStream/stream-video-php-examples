<?php

namespace App\DTO;

/**
 * Audio settings request DTO
 */
class AudioSettingsRequest
{
    public function __construct(
        /** @var bool Whether access requests are enabled */
        private bool $accessRequestEnabled = false,
        
        /** @var string Default audio device ('speaker' or 'earpiece') */
        private string $defaultDevice = 'speaker',
        
        /** @var bool Whether microphone is on by default */
        private bool $micDefaultOn = false,
        
        /** @var bool Whether Opus DTX is enabled */
        private bool $opusDtxEnabled = false,
        
        /** @var bool Whether redundant coding is enabled */
        private bool $redundantCodingEnabled = false,
        
        /** @var bool Whether speaker is on by default */
        private bool $speakerDefaultOn = false,
        
        /** @var NoiseCancellationSettingsRequest|null Noise cancellation settings */
        private ?NoiseCancellationSettingsRequest $noiseCancellation = null
    ) {}

    public function getAccessRequestEnabled(): bool
    {
        return $this->accessRequestEnabled;
    }

    public function getDefaultDevice(): string
    {
        return $this->defaultDevice;
    }

    public function getMicDefaultOn(): bool
    {
        return $this->micDefaultOn;
    }

    public function getOpusDtxEnabled(): bool
    {
        return $this->opusDtxEnabled;
    }

    public function getRedundantCodingEnabled(): bool
    {
        return $this->redundantCodingEnabled;
    }

    public function getSpeakerDefaultOn(): bool
    {
        return $this->speakerDefaultOn;
    }

    public function getNoiseCancellation(): ?NoiseCancellationSettingsRequest
    {
        return $this->noiseCancellation;
    }

    public function toArray(): array
    {
        $data = [
            'access_request_enabled' => $this->accessRequestEnabled,
            'default_device' => $this->defaultDevice,
            'mic_default_on' => $this->micDefaultOn,
            'opus_dtx_enabled' => $this->opusDtxEnabled,
            'redundant_coding_enabled' => $this->redundantCodingEnabled,
            'speaker_default_on' => $this->speakerDefaultOn,
        ];

        if ($this->noiseCancellation !== null) {
            $data['noise_cancellation'] = $this->noiseCancellation->toArray();
        }

        return $data;
    }
} 