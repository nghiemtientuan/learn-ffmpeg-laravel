<?php

namespace App\Jobs;

use Carbon\Carbon;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ConvertVideoForDownloading implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        // create a video format...
        $lowBitrateFormat = (new X264)->setKiloBitrate(500);

        // open the uploaded video from the right disk...
        FFMpeg::open($this->video->path)

            // add the 'resize' filter...
            ->addFilter(function ($filters) {
                $filters->resize(new Dimension(960, 540));
            })

            // call the 'export' method...
            ->export()

            // tell the MediaExporter to which disk and in which format we want to export...
            ->toDisk('downloadable_videos')
            ->inFormat($lowBitrateFormat)

            // call the 'save' method with a filename...
            ->save($this->video->id . '.mp4');
    }
}
