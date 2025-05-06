<?php

namespace App\DTO;

/**
 * Screensharing settings request DTO
 */
class ScreensharingSettingsRequest {
    public function __construct(
        /** @var bool Whether access requests are enabled */
        private bool $accessRequestEnabled,
        
        /** @var bool Whether screensharing is enabled */
        private bool $enabled,
        
        /** @var TargetResolution|null Target resolution for screensharing */
        private ?TargetResolution $targetResolution = null
    ) {}

    public function getAccessRequestEnabled(): bool
    {
        return $this->accessRequestEnabled;
    }

    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    public function getTargetResolution(): ?TargetResolution
    {
        return $this->targetResolution;
    }

    public function toArray(): array
    {
        $data = [
            'access_request_enabled' => $this->accessRequestEnabled,
            'enabled' => $this->enabled
        ];
        
        if ($this->targetResolution !== null) {
            $data['target_resolution'] = $this->targetResolution->toArray();
        }
        
        return $data;
    }
}