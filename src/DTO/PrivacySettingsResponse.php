<?php

namespace App\DTO;

class PrivacySettingsResponse
{
    public function __construct(
        /** @var ReadReceiptsResponse|null Read receipts settings */
        private ?ReadReceiptsResponse $readReceipts = null,
        /** @var TypingIndicatorsResponse|null Typing indicators settings */
        private ?TypingIndicatorsResponse $typingIndicators = null
    ) {}

    public function getReadReceipts(): ?ReadReceiptsResponse
    {
        return $this->readReceipts;
    }

    public function getTypingIndicators(): ?TypingIndicatorsResponse
    {
        return $this->typingIndicators;
    }

    public function toArray(): array
    {
        $data = [];

        if ($this->readReceipts !== null) {
            $data['read_receipts'] = $this->readReceipts->toArray();
        }

        if ($this->typingIndicators !== null) {
            $data['typing_indicators'] = $this->typingIndicators->toArray();
        }

        return $data;
    }
} 