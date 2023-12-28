<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Livewire\WithFileUploads;

trait ImageTrait
{
    use WithFileUploads;

    public function apiImgur($model): mixed
    {
    
        $response = Http::withHeaders([
            'Authorization' => 'Client-ID ' . env('IMGUR_ID'),
        ])->attach('image', file_get_contents($this->imag->getRealPath()), $this->imag->getClientOriginalName())
        ->post('https://api.imgur.com/3/image');

        if ($response->successful()) {
            if ($model->image()->exists()) {
                $data = $response->json();
                $oldImage = $model->image()->where('imageable_id', $model->id)->first();
                $oldImage->delete([$oldImage->data->url]);
                $oldImage->delete();
            }
            $model->image()->updateOrCreate(['url' => $oldImage->data->url]);
            // dd($data);
            // dd($data['data']['deletehash']);
            // $image = new Image;
            // $image->url = $data['data']['link'];
            // $image->imageable_type = User::class;
            // $image->imageable_id = $this->user->id;
            // return $this->user->image()->save($this->image);

        } else {
            $data = $response->json();
            return $data['data']['error'];
            
        }

        // $data = $response->json();
        // // dd($data);
        // return $data;

    }

    // public function insertModel($model): mixed
    // {
    //     if ($model->image()->exists()) {
    //         $oldImage = $model->image()->where('imageable_id', $model->id)->first();
    //         $oldImage->delete([$oldImage->url]);
    //         $oldImage->delete();
    //     }
    //     $model->image()->updateOrCreate(['url' => $oldImage->url]);
    // }
}
