<?php

namespace App\DTO;

class GoLiveRequest
{
    private ?string $recording_storage_name;
    private ?bool $start_closed_caption;
    private ?bool $start_hls;
    private ?bool $start_recording;
    private ?bool $start_transcription;
    private ?string $transcription_storage_name;

    public function __construct(
        ?string $recording_storage_name = null,
        ?bool $start_closed_caption = null,
        ?bool $start_hls = null,
        ?bool $start_recording = null,
        ?bool $start_transcription = null,
        ?string $transcription_storage_name = null
    ) {
        $this->recording_storage_name = $recording_storage_name;
        $this->start_closed_caption = $start_closed_caption;
        $this->start_hls = $start_hls;
        $this->start_recording = $start_recording;
        $this->start_transcription = $start_transcription;
        $this->transcription_storage_name = $transcription_storage_name;
    }

    /**
     * Convert the DTO to an array
     *
     * @return array|null
     */
    public function toArray(): ?array
    {
        $data = [];

        if ($this->recording_storage_name !== null) {
            $data['recording_storage_name'] = $this->recording_storage_name;
        }

        if ($this->start_closed_caption !== null) {
            $data['start_closed_caption'] = $this->start_closed_caption;
        }

        if ($this->start_hls !== null) {
            $data['start_hls'] = $this->start_hls;
        }

        if ($this->start_recording !== null) {
            $data['start_recording'] = $this->start_recording;
        }

        if ($this->start_transcription !== null) {
            $data['start_transcription'] = $this->start_transcription;
        }

        if ($this->transcription_storage_name !== null) {
            $data['transcription_storage_name'] = $this->transcription_storage_name;
        }

        return empty($data) ? null : $data;
    }
} 