<?php

namespace App\Http\Controllers;

use App\Photo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Intervention\Image\Facades\Image;


class PhotoController extends Controller
{
    public function index()
    {
        return response(Photo::get()->jsonSerialize(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $i = -1;
        foreach ($request as $val) {
            $i++;
            if (!isset($request['file' . $i])) break;
            $item = new Photo();
            $image = $request['file' . $i];
            $imageType = $image->getClientOriginalExtension();
            $imageStr = (string)Image::make($image)->
            resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode($imageType);

            $item->picture = base64_encode($imageStr);
            $item->image_type = $imageType;
            $item->owner_id = $request['owner_id'];
            $item->linked = $request['linked'];

//        $item->title = $request->get('title');
//        $item->description = $request->get('description');

            $item->save();
        }

        return response($i, Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $item = Photo::findOrFail($id);
        $item->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $item = Photo::find($id);
        try {
            $item->delete();
        } catch (Exception $e) {
        }
    }

    public function show($id)
    {
        return Photo::findOrFail($id);
    }
}
