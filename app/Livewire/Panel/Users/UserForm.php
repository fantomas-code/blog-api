<?php

namespace App\Livewire\Panel\Users;

use App\Models\User;
use Livewire\Component;
use App\Traits\ImageTrait;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class UserForm extends Component
{
    use ImageTrait;
    public User $user;
    public $image;

    public function mount(User $user) {
        $this->user = $user;
    }

    protected function rules(): array {
        return [
            'image' => [
                Rule::requiredIf(! $this->user->image),
                Rule::when($this->image, ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048']),
            ],
            'user.name'     => 'required|min:3',
            'user.nickname' => 'nullable|min:3|exists:users,nickname',
            'user.slug'     => [
                'alpha_dash',
                Rule::unique('users', 'slug')->ignore($this->user),
            ],
            'user.phone'    => 'nullable|numeric|min:10|exists:users,phone',
            'user.email' => [
                'required',
                Rule::unique('users', 'email')->ignore($this->user)
            ],
        ];
    }

    #[Title('Form User 😎')]
    public function render()
    {
        return view('livewire.panel.users.user-form');
    }



    public function userRegister(): mixed
    {
       $this->validate();
       
       // $loadImage = $this->uploadImage($this->image);
        if ($this->image) {
            $this->image = $this->uploadImage();
            $this->cleanimage();
        }
        // dd($loadImage);
        $img = $this->image = $data['data']['link'];
        $this->user->image()->create([
            'url' => $img,
        ]);
        return to_route('blog')->with('status','Datos creados exitosamente');

    }

    public function cleanimage()
    {
        $fileold = Storage::files('livewire-tmp');
        
        foreach ($fileold as $file) {
            Storage::delete($file);
        }
    }
}
