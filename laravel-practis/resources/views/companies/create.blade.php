<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Companies') }}
        </h2>
    </x-slot>
    <x-alert type="error" :message="$errors"/>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{ Form::open(['url' => route('companies.store')]) }}

                {{ Form::label('name', 'Name') }}
                {{ Form::text('name', old('name'), ['placeholder' => '会社名']) }}

                <div>
                    {{ Form::submit('Save') }}
                </div>

                {{ Form::close() }}
                <div class="py-4">
                    {{ Html::linkRoute('companies.index', 'もどる') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
