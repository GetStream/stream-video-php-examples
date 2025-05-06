<?php

namespace App\DTO;

/**
 * Transcription settings response DTO
 */
class TranscriptionSettingsResponse
{
    /**
     * Closed caption mode
     * Possible values: 'available', 'disabled', 'auto-on'
     * 
     * @var string
     */
    private string $closed_caption_mode;

    /**
     * Language setting
     * Possible values: 'auto', 'en', 'fr', 'es', 'de', 'it', 'nl', 'pt', 'pl', 'ca', 'cs', 'da', 
     * 'el', 'fi', 'id', 'ja', 'ru', 'sv', 'ta', 'th', 'tr', 'hu', 'ro', 'zh', 'ar', 'tl', 'he', 
     * 'hi', 'hr', 'ko', 'ms', 'no', 'uk'
     * 
     * @var string
     */
    private string $language;

    /**
     * Transcription mode
     * Possible values: 'available', 'disabled', 'auto-on'
     * 
     * @var string
     */
    private string $mode;

    public function __construct(
        string $closed_caption_mode,
        string $language,
        string $mode
    ) {
        $this->closed_caption_mode = $closed_caption_mode;
        $this->language = $language;
        $this->mode = $mode;
    }

    public function getClosedCaptionMode(): string
    {
        return $this->closed_caption_mode;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function getMode(): string
    {
        return $this->mode;
    }

    public function toArray(): array
    {
        return [
            'closed_caption_mode' => $this->closed_caption_mode,
            'language' => $this->language,
            'mode' => $this->mode
        ];
    }
} 