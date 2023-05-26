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
                <div class="p-4">
                    部署名：
                    <a href="{{ route('companies.sections.edit', ['company' => $company->id, 'section' => $section->id]) }}"
                       class="text-indigo-600">{{ $section->name }}</a>
                </div>
                <form
                    action="{{ route('companies.sections.user_sections.store', ['company' => $company, 'section' => $section]) }}"
                    method="POST">
                    @csrf
                    <div class="px-3">
                        <select id="selection" name="user_id">
                            @foreach($company->users as $company_user)
                                <option value="{{ $company_user->id }}">{{ $company_user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="p-4">{{ $section->name }} に配属</button>
                </form>
                <div class="py-4">
                    <a href="{{ route('companies.show', ['company' => $company]) }}"
                       class="px-3 text-indigo-600">もどる</a>
                </div>
                <h2>所属しているユーザー</h2>
                @foreach($section->users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
