<?php

namespace App\Http\Controllers;

use App\Http\Requests\Story\StoreRequest;
use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Filters\Video\ResizeFilter;
use FFMpeg\Format\Video\X264;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class StoryController extends Controller
{

    public function store(StoreRequest $request)
    {

        $filePath = $request->file->store('temp', 'public');
        $filePath = explode('/', $filePath)[1];
        $path = public_path("storage\\temp\\") . $filePath;

        $pathForMime = implode('\\',array_diff(array_slice(explode('\\', $path), -4, 4), ['storage'])); // Fucking Storage specificity (exclude '/storage/')
        $mimetype = Storage::mimeType($pathForMime);
        if (strpos($mimetype, 'image') !== false) {
            // File is image
            // Detecting 'average' color of image
            $image = imagecreatefromjpeg($path);
            $thumb = imagecreatetruecolor(1, 1);
            imagecopyresampled($thumb, $image, 0, 0, 0, 0, 1, 1, imagesx($image), imagesy($image));
            $mainColor = strtoupper(dechex(imagecolorat($thumb, 0, 0)));
            $r = round((hexdec(substr($mainColor, 1, 2)) - 119) / 255 * 100);
            $g = round((hexdec(substr($mainColor, 3, 2)) - 119) / 255 * 100);
            $b = round((hexdec(substr($mainColor, 5, 2)) - 119) / 255 * 100);
            $gradient = Image::make(public_path("/storage/stories/gradient.png"))->colorize($r, $g, $b);

            $image = Image::make($path)->widen(1080);

            $newPath = explode('\\', $path); //TODO DO SMTH ITS PIZDA
            $newPath[count($newPath)-2] = 'stories';
            $newPath = implode('\\', $newPath);

            $gradient->insert($image, 'center')->save($newPath);
        } else if (strpos($mimetype, 'video') !== false) {
            //Video
            $ffmpeg = FFMpeg::create(['ffmpeg.binaries'  => 'C:/laragon/bin/ffmpeg/bin/ffmpeg.exe', 'ffprobe.binaries' => 'C:/laragon/bin/ffmpeg/bin/ffprobe.exe']);
            $video = $ffmpeg->open($path);
            $video->filters()->resize(new Dimension(720, 1280), ResizeFilter::RESIZEMODE_SCALE_HEIGHT, true)->synchronize();

            $newPath = explode('\\', $path); //TODO SAME SHIT
            $newPath[count($newPath)-2] = 'stories';
            $newPath = implode('\\', $newPath);

            $video->save(new X264('aac'), $newPath);
        } else {
            return response()->json(['status' => 'error',
                'message' => 'unsupported filetype'], 406);
        }


        Auth::user()->stories()->create(['file' => $filePath]);

        return response()->json(['status' => 'success'], 201);

    }

    // TODO: ВИНЕСТИ НАХУЙ ЗВІДСИ!!
    public function test()
    {

    }
}
