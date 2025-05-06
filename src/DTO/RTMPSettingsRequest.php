<?php

namespace App\DTO;

/**
 * RTMP settings request DTO
 */
class RTMPSettingsRequest
{
    /**
     * @param bool|null $enabled Whether RTMP is enabled
     * @param string|null $quality Video quality ('360p', '480p', '720p', '1080p', '1440p', 'portrait-360x640', 'portrait-480x854', 'portrait-720x1280', 'portrait-1080x1920', 'portrait-1440x2560')
     * @param LayoutSettingsRequest|null $layout Layout settings
     */
    public function __construct(
        /** @var bool|null Whether RTMP is enabled */
        private ?bool $enabled = null,
        
        /** @var string|null Video quality ('360p', '480p', '720p', '1080p', '1440p', 'portrait-360x640', 'portrait-480x854', 'portrait-720x1280', 'portrait-1080x1920', 'portrait-1440x2560') */
        private ?string $quality = null,
        
        /** @var LayoutSettingsRequest|null Layout settings */
        private ?LayoutSettingsRequest $layout = null
    ) {}

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function getQuality(): ?string
    {
        return $this->quality;
    }

    public function getLayout(): ?LayoutSettingsRequest
    {
        return $this->layout;
    }

    public function toArray(): array
    {
        $data = [];
        
        if ($this->enabled !== null) {
            $data['enabled'] = $this->enabled;
        }
        
        if ($this->quality !== null) {
            $data['quality'] = $this->quality;
        }
        
        if ($this->layout !== null) {
            $data['layout'] = $this->layout->toArray();
        }
        
        return $data;
    }
} 