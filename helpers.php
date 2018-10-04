<?php

if (!function_exists('saveImage')) {

    function saveImage($value, $destination_path, $disk='publicmedia', $size = array(), $watermark = array())
    {

        $default_size = [
            'imagesize' => [
                'width' => 1024,
                'height' => 768,
                'quality'=>80
            ],
            'mediumthumbsize' => [
                'width' => 400,
                'height' => 300,
                'quality'=>80
            ],
            'smallthumbsize' => [
                'width' => 100,
                'height' => 80,
                'quality'=>80
            ],
        ];
        $default_watermark=[
            'activated' => false,
            'url' => 'modules/ihelpers/img/watermark/watermark.png',
            'position' => 'top-left',
            'x' => 10,
            'y' => 10,
        ];
        $size = json_decode(json_encode(array_merge($default_size, $size)));
        $watermark = json_decode(json_encode(array_merge($default_watermark, $watermark)));

        //Defined return.
        if (ends_with($value, '.jpg')) {
            return $value;
        }

        // if a base64 was sent, store it in the db
        if (starts_with($value, 'data:image')) {
            // 0. Make the image
            $image = \Image::make($value);
            // resize and prevent possible upsizing

            $image->resize($size->imagesize->width, $size->imagesize->height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            if ($watermark->activated) {
                $image->insert($watermark->url, $watermark->position, $watermark->x, $watermark->y);
            }
            // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path, $image->stream('jpg', $size->imagesize->quality));


            // Save Thumbs
            \Storage::disk($disk)->put(
                str_replace('.jpg', '_mediumThumb.jpg', $destination_path),
                $image->fit($size->mediumthumbsize->width, $size->mediumthumbsize->height)->stream('jpg', $size->mediumthumbsize->quality)
            );

            \Storage::disk($disk)->put(
                str_replace('.jpg', '_smallThumb.jpg', $destination_path),
                $image->fit($size->smallthumbsize->width, $size->smallthumbsize->height)->stream('jpg', $size->smallthumbsize->quality)
            );

            // 3. Return the path
            return $destination_path;
        }

        // if the image was erased
        if ($value == null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($destination_path);

            // set null in the database column
            return null;
        }


    }
}