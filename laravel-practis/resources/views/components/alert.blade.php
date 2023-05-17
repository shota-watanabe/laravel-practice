@if($errors->any())
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach($errors->all() as $error)
                <div class="bg-danger overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        {{ $error }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
