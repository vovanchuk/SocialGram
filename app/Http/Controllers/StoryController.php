<?php

namespace App\Http\Controllers;

use App\Http\Requests\Story\StoreRequest;
use App\Http\Resources\StoryResource;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Filters\Video\ResizeFilter;
use FFMpeg\Format\Video\X264;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class StoryController extends Controller
{

    public function store(StoreRequest $request)
    {

        $fileName = $request->file->store('temp', 'public');
        $fileName = explode('/', $fileName)[1];
        $saveFolder = public_path("storage\\stories\\");
        $fullPath = public_path("storage\\temp\\") . $fileName;

        $pathForMime = implode('\\',array_diff(array_slice(explode('\\', $fullPath), -4, 4), ['storage'])); // Fucking Storage specificity (exclude '/storage/')
        $mimetype = Storage::mimeType($pathForMime);
        $type = strpos($mimetype, 'image') !== false ? 'image' : (strpos($mimetype, 'video') !== false ? 'video' : null);
        if ($type === 'image') {
            $newImage = $this->addBackground($fullPath, $mimetype);

            $newPath = str_replace('\\temp\\', '\\stories\\', $fullPath);
            $newImage->save($newPath);
        } else if ($type === 'video') {
            $ffmpeg = FFMpeg::create(['ffmpeg.binaries'  => 'C:/laragon/bin/ffmpeg/bin/ffmpeg.exe', 'ffprobe.binaries' => 'C:/laragon/bin/ffmpeg/bin/ffprobe.exe']); //TODO HARDCODED PATHS
            $duration = $ffmpeg->getFFProbe()->format($fullPath)->get('duration');
            if((int)$duration > 15) return response()->json(['status' => 'error', 'message' => 'Video longer than 15 sec'], 422);

            $video = $ffmpeg->open($fullPath);
            $newPath = str_replace('\\temp\\', '\\stories\\', $fullPath);

            $video->filters()->resize(new Dimension(720, 1280), ResizeFilter::RESIZEMODE_SCALE_HEIGHT, true)->synchronize();
            $video->save(new X264('aac'), $newPath);

            $previewName = Str::random(15) . '.jpg';
            $video->frame(TimeCode::fromSeconds(1))->save($saveFolder . $previewName);
            $newImage = $this->addBackground($saveFolder . $previewName, 'image/jpeg');
            $newImage->save($saveFolder . $previewName);
        } else {
            return response()->json(['status' => 'error',
                'message' => 'Unsupported filetype'], 406);
        }

        $storyObj = array('file' => $fileName, 'type' => $type);
        if($type === 'video'){
            $storyObj = array_merge($storyObj, array('preview' => $previewName, 'duration' => $duration));
        }

        $story = Auth::user()->stories()->create($storyObj);

        return response()->json(['status' => 'success', 'data' => new StoryResource($story)], 201);

    }

    // TODO: ВИНЕСТИ НАХУЙ ЗВІДСИ!!
    public function addBackground($path, $mimetype = null)
    {
        $image = null;
        if(strpos($mimetype, 'image/png') !== false) $image = imagecreatefrompng($path);
        else if(strpos($mimetype, 'image/gif') !== false) $image = imagecreatefromgif($path);
        else if(strpos($mimetype, 'image/jpeg') !== false) $image = imagecreatefromjpeg($path);
        if(!$image) throw new UnprocessableEntityHttpException();

        // Detecting 'average' color of image
        $thumb = imagecreatetruecolor(1, 1);
        imagecopyresampled($thumb, $image, 0, 0, 0, 0, 1, 1, imagesx($image), imagesy($image));
        $mainColor = strtoupper(dechex(imagecolorat($thumb, 0, 0)));
        $r = round((hexdec(substr($mainColor, 1, 2)) - 119) / 255 * 100);
        $g = round((hexdec(substr($mainColor, 3, 2)) - 119) / 255 * 100);
        $b = round((hexdec(substr($mainColor, 5, 2)) - 119) / 255 * 100);
        $gradient = Image::make(public_path("/storage/stories/gradient.png"))->colorize($r, $g, $b);

        $image = Image::make($path)->widen(1080);
        $gradient->insert($image, 'center');

        return $gradient;
    }

}
