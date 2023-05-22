<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Companies') }}
        </h2>
    </x-slot>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{ Html::linkRoute('companies.create', '新規作成') }}
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(count($companies) >= 1)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($companies as $company)
                            <tr>
                                <td>{{ $company->id }}</td>
                                <td>{{ Html::linkRoute('companies.show', $company->name, compact('company')) }}</td>
                                <td>{{ $company->created_at }}</td>
                                <td>{{ $company->updated_at }}</td>
                                <td><button type="button" onclick="location.href='{{ route('companies.sections.create', ['company' => $company->id]) }}'">部署登録</button></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                会社は登録されていません。
            @endif
        </div>
    </div>
</x-app-layout>
