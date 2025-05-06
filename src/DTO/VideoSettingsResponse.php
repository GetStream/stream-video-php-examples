<?php

namespace App\DTO;

/**
 * Video settings response DTO
 */
class VideoSettingsResponse
{
    /**
     * Whether access request is enabled
     * 
     * @var bool
     */
    private bool $access_request_enabled;

    /**
     * Whether camera is on by default
     * 
     * @var bool
     */
    private bool $camera_default_on;

    /**
     * Camera facing direction
     * Possible values: 'front', 'back', 'external'
     * 
     * @var string
     */
    private string $camera_facing;

    /**
     * Whether video is enabled
     * 
     * @var bool
     */
    private bool $enabled;

    /**
     * Target resolution settings
     * 
     * @var TargetResolution
     */
    private TargetResolution $target_resolution;

    public function __construct(
        bool $access_request_enabled,
        bool $camera_default_on,
        string $camera_facing,
        bool $enabled,
        TargetResolution $target_resolution
    ) {
        $this->access_request_enabled = $access_request_enabled;
        $this->camera_default_on = $camera_default_on;
        $this->camera_facing = $camera_facing;
        $this->enabled = $enabled;
        $this->target_resolution = $target_resolution;
    }

    public function isAccessRequestEnabled(): bool
    {
        return $this->access_request_enabled;
    }

    public function isCameraDefaultOn(): bool
    {
        return $this->camera_default_on;
    }

    public function getCameraFacing(): string
    {
        return $this->camera_facing;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function getTargetResolution(): TargetResolution
    {
        return $this->target_resolution;
    }

    public function toArray(): array
    {
        return [
            'access_request_enabled' => $this->access_request_enabled,
            'camera_default_on' => $this->camera_default_on,
            'camera_facing' => $this->camera_facing,
            'enabled' => $this->enabled,
            'target_resolution' => $this->target_resolution->toArray()
        ];
    }
} 