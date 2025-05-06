<?php

namespace App\DTO;

/**
 * Thumbnails settings request DTO
 */
class ThumbnailsSettingsRequest
{
    /**
     * Whether thumbnails are enabled
     * 
     * @var bool|null
     */
    private ?bool $enabled;

    public function __construct(?bool $enabled = null)
    {
        $this->enabled = $enabled;
    }

    public function toArray(): array
    {
        return [
            'enabled' => $this->enabled,
        ];
    }
} 