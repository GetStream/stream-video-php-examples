<?php

namespace App\DTO;

/**
 * Layout settings request DTO
 */
class LayoutSettingsRequest
{
    /**
     * @param string $name Layout name ('spotlight', 'grid', 'single-participant', 'mobile', or 'custom')
     * @param bool|null $detectOrientation Whether to detect orientation
     * @param string|null $externalAppUrl URL to external app
     * @param string|null $externalCssUrl URL to external CSS
     * @param array|null $options Additional options for the layout
     */
    public function __construct(
        /** @var string Layout name ('spotlight', 'grid', 'single-participant', 'mobile', or 'custom') */
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