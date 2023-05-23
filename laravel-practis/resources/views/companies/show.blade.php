<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Companies') }}
        </h2>
    </x-slot>

    @if($errors->any())
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @foreach($errors->all() as $error)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            {{ $error }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{ Form::open(['url' => route('companies.update', compact('company')), 'method' => 'PUT']) }}

                {{ Form::label('name', 'Name') }}
                {{ Form::text('name', old('name', $company->name), ['placeholder' => '会社名']) }}

                <div>
                    {{ Form::submit('Save') }}
                </div>

                {{ Form::close() }}
                <a href="{{ route('companies.index') }}">もどる</a>
            </div>
        </div>
    </div>
</x-app-layout>
