<?php

namespace App\DTO;

/**
 * Ring settings response DTO
 */
class RingSettingsResponse
{
    public function __construct(
        /** @var int Time in milliseconds before auto-canceling a call */
        private int $autoCancelTimeoutMs,
        
        /** @var int Time in milliseconds before an incoming call times out */
        private int $incomingCallTimeoutMs,
        
        /** @var int Time in milliseconds before a missed call times out */
        private int $missedCallTimeoutMs
    ) {}

    public function getAutoCancelTimeoutMs(): int
    {
        return $this->autoCancelTimeoutMs;
    }

    public function getIncomingCallTimeoutMs(): int
    {
        return $this->incomingCallTimeoutMs;
    }

    public function getMissedCallTimeoutMs(): int
    {
        return $this->missedCallTimeoutMs;
    }

    public function toArray(): array
    {
        return [
            'auto_cancel_timeout_ms' => $this->autoCancelTimeoutMs,
            'incoming_call_timeout_ms' => $this->incomingCallTimeoutMs,
            'missed_call_timeout_ms' => $this->missedCallTimeoutMs
        ];
    }
} 