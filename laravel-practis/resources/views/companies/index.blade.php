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
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @if(count($companies) >= 1)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Sections
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created At
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Updated At
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($companies as $company)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $company->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-indigo-600">
                                        {{ Html::linkRoute('companies.show', $company->name, compact('company')) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if(count($company->sections) >= 1)
                                            <ul class="list-disc list-inside text-indigo-600">
                                                @foreach($company->sections as $section)
                                                    <li>{{ Html::linkRoute('companies.sections.edit', $section->name, compact('company', 'section')) }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $company->created_at }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $company->updated_at }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('companies.sections.create', ['company' => $company->id]) }}"
                                           class="text-indigo-600">部署登録</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
                        <p class="text-lg text-gray-500">会社は登録されていません。</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
