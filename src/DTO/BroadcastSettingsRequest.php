<?php

namespace App\DTO;

/**
 * Broadcast settings request DTO
 */
class BroadcastSettingsRequest
{
    public function __construct(
        /** @var bool|null Whether broadcasting is enabled */
        private ?bool $enabled = null,
        
        /** @var HLSSettingsRequest|null HLS settings */
        private ?HLSSettingsRequest $hls = null,
        
        /** @var RTMPSettingsRequest|null RTMP settings */
        private ?RTMPSettingsRequest $rtmp = null
    ) {}

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function getHls(): ?HLSSettingsRequest
    {
        return $this->hls;
    }

    public function getRtmp(): ?RTMPSettingsRequest
    {
        return $this->rtmp;
    }

    public function toArray(): array
    {
        $data = [];
        
        if ($this->enabled !== null) {
            $data['enabled'] = $this->enabled;
        }
        
        if ($this->hls !== null) {
            $data['hls'] = $this->hls->toArray();
        }
        
        if ($this->rtmp !== null) {
            $data['rtmp'] = $this->rtmp->toArray();
        }
        
        return $data;
    }
} 