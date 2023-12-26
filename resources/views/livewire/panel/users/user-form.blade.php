<div>
    <style>
        body div, form{
            display: flex;
            flex-direction: column;
            gap: 1rem;
            font-size: 2rem;
            box-sizing: border-box;
        }

        button{
            cursor: pointer;
        }

        form{
            width: 50%;
            margin-right: auto;
            margin-left: auto;
        }

        input, button{
            font-size: 1.5rem;
            font-style: italic;
        }

        input[type=file]::before{
            content: "Seleccion una imagen de perfil ..";
            padding: .8rem 1rem;
            left: 7rem;
        }

        input[type="file"]::after{
            content: 'Select some files';
            position: absolute;
            z-index: -1;
            top: 10px;
            left: 8px;
            font-size: 17px;
            color: #b8b8b8
        }
        img{
            width: 40%;
            height: 40%;
        }
    </style>
    <a href="{{ route('blog') }}">Inicio</a>

    <form wire:submit="userRegister" enctype="multipart/form-data">

        @if ($this->image)
            <img src="{{ $image?->temporaryUrl() }}" />
        @endif

        <input wire:model="user.name" type="text" placeholder="Nombre">
        @error("user.name")
            <span class="text-red-300">{{ $message }}</span>
        @enderror
        <input wire:model="user.nickname" type="text" placeholder="Sobrenombre">
        @error("user.nickname")
            <span class="text-red-300">{{ $message }}</span>
        @enderror
        <input wire:model="user.phone" type="tel" placeholder="Telefono">
        @error("user.phone")
            <span class="text-red-300">{{ $message }}</span>
        @enderror
        <input wire:model="user.email" type="email" placeholder="Correo">
        @error("user.email")
            <span class="text-red-300">{{ $message }}</span>
        @enderror
        <input wire:model="image" accept="image/*" type="file" >
        @error("image")
            <span class="text-red-300">{{ $message }}</span>
        @enderror
        <button type="submit">
            Enviar
        </button>
    </form>
</div>
