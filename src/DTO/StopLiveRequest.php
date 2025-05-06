<?php

namespace App\DTO;

class StopLiveRequest
{
    private ?bool $continue_closed_caption;
    private ?bool $continue_hls;
    private ?bool $continue_recording;
    private ?bool $continue_rtmp_broadcasts;
    private ?bool $continue_transcription;

    public function __construct(
        ?bool $continue_closed_caption = null,
        ?bool $continue_hls = null,
        ?bool $continue_recording = null,
        ?bool $continue_rtmp_broadcasts = null,
        ?bool $continue_transcription = null
    ) {
        $this->continue_closed_caption = $continue_closed_caption;
        $this->continue_hls = $continue_hls;
        $this->continue_recording = $continue_recording;
        $this->continue_rtmp_broadcasts = $continue_rtmp_broadcasts;
        $this->continue_transcription = $continue_transcription;
    }

    /**
     * Convert the DTO to an array
     *
     * @return array|null
     */
    public function toArray(): ?array
    {
        $data = [];

        if ($this->continue_closed_caption !== null) {
            $data['continue_closed_caption'] = $this->continue_closed_caption;
        }

        if ($this->continue_hls !== null) {
            $data['continue_hls'] = $this->continue_hls;
        }

        if ($this->continue_recording !== null) {
            $data['continue_recording'] = $this->continue_recording;
        }

        if ($this->continue_rtmp_broadcasts !== null) {
            $data['continue_rtmp_broadcasts'] = $this->continue_rtmp_broadcasts;
        }

        if ($this->continue_transcription !== null) {
            $data['continue_transcription'] = $this->continue_transcription;
        }

        return empty($data) ? null : $data;
    }
} 