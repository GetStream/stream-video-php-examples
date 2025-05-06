<?php

namespace App\DTO;

/**
 * Layout settings response DTO
 */
class LayoutSettingsResponse
{
    public function __construct(
        /** @var string Layout name */
        private string $name,
        
        /** @var bool|null Whether to detect orientation */
        private ?bool $detectOrientation = null,
        
        /** @var string|null URL to external app */
        private ?string $externalAppUrl = null,
        
        /** @var string|null URL to external CSS */
        private ?string $externalCssUrl = null,
        
        /** @var array|null Additional options for the layout */
        private ?array $options = null
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getDetectOrientation(): ?bool
    {
        return $this->detectOrientation;
    }

    public function getExternalAppUrl(): ?string
    {
        return $this->externalAppUrl;
    }

    public function getExternalCssUrl(): ?string
    {
        return $this->externalCssUrl;
    }

    public function getOptions(): ?array
    {
        return $this->options;
    }

    public function toArray(): array
    {
        $data = [
            'name' => $this->name
        ];
        
        if ($this->detectOrientation !== null) {
            $data['detect_orientation'] = $this->detectOrientation;
        }
        
        if ($this->externalAppUrl !== null) {
            $data['external_app_url'] = $this->externalAppUrl;
        }
        
        if ($this->externalCssUrl !== null) {
            $data['external_css_url'] = $this->externalCssUrl;
        }
        
        if ($this->options !== null) {
            $data['options'] = $this->options;
        }
        
        return $data;
    }
} 