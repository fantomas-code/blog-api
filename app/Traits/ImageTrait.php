<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Livewire\WithFileUploads;

trait ImageTrait
{
    use WithFileUploads;

    public function uploadImage(): mixed
    {
    
        $response = Http::withHeaders([
            'Authorization' => 'Client-ID ' . env('IMGUR_ID'),
        ])->attach('image', file_get_contents($this->image->getRealPath()), $this->image->getClientOriginalName())
        ->post('https://api.imgur.com/3/image');

        $data = $response->json();

        return $data;

    }
}
