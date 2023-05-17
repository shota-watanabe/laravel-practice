@php($counter = 1)

<html>
    <body>
        <h1>Hello, {{ $name }}</h1><br>
        <h1>{{ $occupation }}</h1>
        @auth
            <div>認証済みです</div>
        @endauth
        @guest
            <div>認証されていません</div>
        @endguest

        @for ($i = 0; $i < 10; $i++)
            {{ $i }}
        @endfor
        <br>
        @for ($i = 0; $i < 10; $i++)
            {{ $i  }}
            @break($i == 3)
        @endfor
        <br>
        {{ $counter }}<br>

        <x-test>
            <x-slot:title>
                Server Error
                </x-slot:title>

                <strong>Whoops!</strong> Something went wrong!
        </x-test>

    </body>
</html>
