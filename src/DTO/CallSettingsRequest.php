<?php

namespace App\DTO;

/**
 * Call settings request DTO
 */
class CallSettingsRequest
{
    public function __construct(
        /** @var AudioSettingsRequest|null Audio settings */
        private ?AudioSettingsRequest $audio = null,
        /** @var BackstageSettingsRequest|null Backstage settings */
        private ?BackstageSettingsRequest $backstage = null,
        /** @var BroadcastSettingsRequest|null Broadcasting settings */
        private ?BroadcastSettingsRequest $broadcasting = null,
        /** @var FrameRecordingSettingsRequest|null Frame recording settings */
        private ?FrameRecordingSettingsRequest $frameRecording = null,
        /** @var GeofenceSettingsRequest|null Geofencing settings */
        private ?GeofenceSettingsRequest $geofencing = null,
        /** @var LimitsSettingsRequest|null Limits settings */
        private ?LimitsSettingsRequest $limits = null,
        /** @var RecordSettingsRequest|null Recording settings */
        private ?RecordSettingsRequest $recording = null,
        /** @var RingSettingsRequest|null Ring settings */
        private ?RingSettingsRequest $ring = null,
        /** @var ScreensharingSettingsRequest|null Screensharing settings */
        private ?ScreensharingSettingsRequest $screensharing = null,
        /** @var SessionSettingsRequest|null Session settings */
        private ?SessionSettingsRequest $session = null,
        /** @var ThumbnailsSettingsRequest|null Thumbnails settings */
        private ?ThumbnailsSettingsRequest $thumbnails = null,
        /** @var TranscriptionSettingsRequest|null Transcription settings */
        private ?TranscriptionSettingsRequest $transcription = null,
        /** @var VideoSettingsRequest|null Video settings */
        private ?VideoSettingsRequest $video = null
    ) {}

    /**
     * @return AudioSettingsRequest|null
     */
    public function getAudio(): ?AudioSettingsRequest
    {
        return $this->audio;
    }

    /**
     * @return BackstageSettingsRequest|null
     */
    public function getBackstage(): ?BackstageSettingsRequest
    {
        return $this->backstage;
    }

    /**
     * @return BroadcastSettingsRequest|null
     */
    public function getBroadcasting(): ?BroadcastSettingsRequest
    {
        return $this->broadcasting;
    }

    /**
     * @return FrameRecordingSettingsRequest|null
     */
    public function getFrameRecording(): ?FrameRecordingSettingsRequest
    {
        return $this->frameRecording;
    }

    /**
     * @return GeofenceSettingsRequest|null
     */
    public function getGeofencing(): ?GeofenceSettingsRequest
    {
        return $this->geofencing;
    }

    /**
     * @return LimitsSettingsRequest|null
     */
    public function getLimits(): ?LimitsSettingsRequest
    {
        return $this->limits;
    }

    /**
     * @return RecordSettingsRequest|null
     */
    public function getRecording(): ?RecordSettingsRequest
    {
        return $this->recording;
    }

    /**
     * @return RingSettingsRequest|null
     */
    public function getRing(): ?RingSettingsRequest
    {
        return $this->ring;
    }

    /**
     * @return ScreensharingSettingsRequest|null
     */
    public function getScreensharing(): ?ScreensharingSettingsRequest
    {
        return $this->screensharing;
    }

    /**
     * @return SessionSettingsRequest|null
     */
    public function getSession(): ?SessionSettingsRequest
    {
        return $this->session;
    }

    /**
     * @return ThumbnailsSettingsRequest|null
     */
    public function getThumbnails(): ?ThumbnailsSettingsRequest
    {
        return $this->thumbnails;
    }

    /**
     * @return TranscriptionSettingsRequest|null
     */
    public function getTranscription(): ?TranscriptionSettingsRequest
    {
        return $this->transcription;
    }

    /**
     * @return VideoSettingsRequest|null
     */
    public function getVideo(): ?VideoSettingsRequest
    {
        return $this->video;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [];

        if ($this->audio !== null) {
            $data['audio'] = $this->audio->toArray();
        }

        if ($this->backstage !== null) {
            $data['backstage'] = $this->backstage->toArray();
        }

        if ($this->broadcasting !== null) {
            $data['broadcasting'] = $this->broadcasting->toArray();
        }

        if ($this->frameRecording !== null) {
            $data['frame_recording'] = $this->frameRecording->toArray();
        }

        if ($this->geofencing !== null) {
            $data['geofencing'] = $this->geofencing->toArray();
        }

        if ($this->limits !== null) {
            $data['limits'] = $this->limits->toArray();
        }

        if ($this->recording !== null) {
            $data['recording'] = $this->recording->toArray();
        }

        if ($this->ring !== null) {
            $data['ring'] = $this->ring->toArray();
        }

        if ($this->screensharing !== null) {
            $data['screensharing'] = $this->screensharing->toArray();
        }

        if ($this->session !== null) {
            $data['session'] = $this->session->toArray();
        }

        if ($this->thumbnails !== null) {
            $data['thumbnails'] = $this->thumbnails->toArray();
        }

        if ($this->transcription !== null) {
            $data['transcription'] = $this->transcription->toArray();
        }

        if ($this->video !== null) {
            $data['video'] = $this->video->toArray();
        }

        return $data;
    }
} 