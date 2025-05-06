<?php

namespace App\DTO;

/**
 * Geofence settings request DTO
 */
class GeofenceSettingsRequest
{
    /**
     * @param string[]|null $names Array of geofence names
     */
    public function __construct(
        /** @var string[]|null Array of geofence names */
        private ?array $names = null
    ) {}

    /**
     * @return string[]|null
     */
    public function getNames(): ?array
    {
        return $this->names;
    }

    public function toArray(): array
    {
        $data = [];
        
        if ($this->names !== null) {
            $data['names'] = $this->names;
        }
        
        return $data;
    }
} 