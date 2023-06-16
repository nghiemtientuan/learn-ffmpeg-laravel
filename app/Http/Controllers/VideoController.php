<?php

namespace App\Http\Controllers;

use FFMpeg\Format\Video\X264;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class VideoController extends Controller
{
    public function getVideo()
    {
        // create some video formats...
        $lowBitrateFormat  = (new X264)->setKiloBitrate(500);
        $midBitrateFormat  = (new X264)->setKiloBitrate(1500);
        $highBitrateFormat = (new X264)->setKiloBitrate(3000);

        // open the uploaded video from the right disk...
        // File in storage/app/public/1.mp4
        FFMpeg::open('1.mp4')

            // call the 'exportForHLS' method and specify the disk to which we want to export...
            ->exportForHLS()

            // we'll add different formats so the stream will play smoothly
            // with all kinds of internet connections...
            ->addFormat($lowBitrateFormat)
            ->addFormat($midBitrateFormat)
            ->addFormat($highBitrateFormat)

            // call the 'save' method with a filename...
            ->save('1stream' . '.m3u8');
        // File output in storage/app/public/1stream.m3u8
    }

    public function getVideoRender()
    {
        return view('videRender');
    }
}
