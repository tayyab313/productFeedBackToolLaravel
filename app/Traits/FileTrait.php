<?php
namespace App\Traits;

trait FileTrait
{
    public function uploadFile($request) : string
    {
        $file = $request->file('attachments');
        $imageName = time().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('/FeedbackImages'), $imageName);
        return $imageName;
    }
}
