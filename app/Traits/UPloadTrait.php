<?php

namespace App\Traits;

use App\Models\Image;
use Illuminate\Http\Request;

trait UPloadTrait
{

    public function StoreImageAndVerify(Request $request, $inputImage, $folderName, $disk, $imageable_type, $imageable_id)
    {
        if ($request->hasFile($inputImage)) {




            //check image
            if (!$request->file($inputImage)->isValid()) {
                flash('Invalid Image!')->error()->important();
                return redirect()->back()->withInput();
            }

            $photo = $request->file($inputImage);
            $name = \Str::slug($request->input('name'));
            $fileName = $name . '.' . $photo->getClientOriginalExtension();


            //insert image
            $Image = new Image();
            $Image->fileName = $fileName;
            $Image->imageable_type = $imageable_type;
            $Image->imageable_id = $imageable_id;
            $Image->save();
            return $request->file($inputImage)->storeAs($folderName, $fileName, $disk);

        }

        return null;

    }
}
