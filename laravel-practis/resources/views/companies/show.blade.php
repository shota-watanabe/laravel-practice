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
                                会社名：
                                <a href="{{ route('companies.edit', ['company' => $company->id]) }}" class="text-indigo-600">{{ $company->name }}</a>
                            </div>
                            <div class="py-4">
                                <a href="{{ route('companies.sections.create', ['company' => $company->id]) }}" class="px-3 py-4 text-indigo-600">部署登録</a>
                            </div>
                            <div class="py-4">
                                <a href="{{ route('companies.index') }}" class="px-3 text-indigo-600">もどる</a>
                            </div>
                        @if(count($company->sections) >= 1)
                            <div class="px-3 py-4">部署一覧</div>
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
                            @foreach($sections as $section)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $section->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($section)
                                            <ul class="list-disc list-inside text-indigo-600">
                                                    <li>{{ Html::linkRoute('companies.sections.edit', $section->name, compact('company', 'section')) }}</li>
                                            </ul>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $section->created_at }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $section->updated_at }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
                        <p class="text-lg text-gray-500">部署は登録されていません。</p>
                    </div>
                @endif
            </div>
    </div>
</x-app-layout>
