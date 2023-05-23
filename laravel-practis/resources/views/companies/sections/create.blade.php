<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sections') }}
        </h2>
    </x-slot>
    <x-alert type="error" :message="$errors"/>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div>会社名 {{ $company->name }}</div>
                {{ Form::open(['url' => route('companies.sections.store', ['company' => $company->id])]) }}

                {{ Form::label('name', 'Name') }}
                {{ Form::text('name', old('name'), ['placeholder' => '部署名']) }}

                <div>
                    {{ Form::submit('Save') }}
                </div>
                <a href="{{ route('companies.show', ['company' => $company->id]) }}">もどる</a>

                {{ Form::close() }}
            </div>
        </div>
    </div>
</x-app-layout>
