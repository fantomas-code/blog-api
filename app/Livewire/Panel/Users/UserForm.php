<?php

namespace App\Livewire\Panel\Users;

use App\Models\User;
use Livewire\Component;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class UserForm extends Component
{
    use ImageTrait;
    public User $user;

    public $imag;
    public string $password = '';

    public function mount(User $user) {
        $this->user = $user;
    }

    protected function rules(): array {
        return [
            'imag' => [
                Rule::requiredIf(! $this->user->imag),
                Rule::when($this->imag, ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048']),
            ],
            // 'file' => [
            //     $this->user->file ? '' : '',
            //     'nullable', 
            //     'image', 
            //     'mimes:jpeg,png,jpg,gif,svg', 
            //     'max:2048',
            // ],
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
            'password'   => 'required|min:3'
        ];
    }

    #[Title('Form User 😎')]
    public function render()
    {
        return view('livewire.panel.users.user-form');
    }



    public function userRegister(): mixed
    {
        // $data = Http::dd()->withHeaders(['Authorization' => '']);
        // $data->json_decode();
        // dd($this->uploadImage());
        $this->validate();
        $this->user->password = bcrypt($this->password);
        $this->user->save();

        $data = [];
        if ($this->imag) {
            $this->apiImgur($this->user);
            $this->cleanimage();
        }
        // dd($loadImage);
        // if(count($data) > 0){
        //     $this->imag = $data['data']['link'];
        //     $this->user->image()->create([
        //         'url' => $this->imag,
        //     ]);
        // }
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
