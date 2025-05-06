<?php

namespace App\DTO;

/**
 * HLS settings request DTO
 */
class HLSSettingsRequest
{
    /**
     * @param string[] $qualityTracks Array of quality track names
     * @param bool|null $autoOn Whether auto mode is enabled
     * @param bool|null $enabled Whether HLS is enabled
     * @param LayoutSettingsRequest|null $layout Layout settings
     */
    public function __construct(
        /** @var string[] Quality tracks */
        private array $qualityTracks = [],
        
        /** @var bool|null Whether auto mode is enabled */
        private ?bool $autoOn = null,
        
        /** @var bool|null Whether HLS is enabled */
        private ?bool $enabled = null,
        
        /** @var LayoutSettingsRequest|null Layout settings */
        private ?LayoutSettingsRequest $layout = null
    ) {}

    /**
     * @return string[]
     */
    public function getQualityTracks(): array
    {
        return $this->qualityTracks;
    }

    public function getAutoOn(): ?bool
    {
        return $this->autoOn;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function getLayout(): ?LayoutSettingsRequest
    {
        return $this->layout;
    }

    public function toArray(): array
    {
        $data = [
            'quality_tracks' => $this->qualityTracks
        ];
        
        if ($this->autoOn !== null) {
            $data['auto_on'] = $this->autoOn;
        }
        
        if ($this->enabled !== null) {
            $data['enabled'] = $this->enabled;
        }
        
        if ($this->layout !== null) {
            $data['layout'] = $this->layout->toArray();
        }
        
        return $data;
    }
} 