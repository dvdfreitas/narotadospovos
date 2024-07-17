<x-appLayout>
    <div class="max-w-md m-auto px-4 my-10 sm:px-0 sm:max-w-xl md:max-w-2xl lg:max-w-4xl xl:max-w-6xl xl:mx-20 2xl:max-w-full transition-all duration-75 ease-in-out">
        <form method="POST" action="/stories" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-flow-row gap-6 lg:grid lg:grid-cols-2 border-b border-gray-900/10 pb-8 transition-all duration-75 ease-in-out">
                <div class="col-span-1 content-center rounded-lg border border-dashed border-gray-900/25">
                    <div class="min-h-full flex flex-col justify-center items-center text-center space-y-2">
                        <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                        </svg>
                        <div class="flex text-sm leading-6 text-gray-600">
                            <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                <span class="p-2">Upload de imagem</span>
                                <x-input type="file" name="image" id="file-upload" class="sr-only" />                                
                            </label>
                            <p class="pl-1">ou arreste e solta</p>
                        </div>
                        <p class="text-xs leading-5 text-gray-600">Tipo de ficheiro aceite: PNG, JPG, GIF up to 10MB</p>
                        <x-input-error for="image" />
                    </div>
                </div>
                <div class="col-span-1 space-y-8 sm:space-y-6">
                    <fieldset class="space-y-2">
                        <x-label>Título</x-label>
                        <div>                            
                            <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus/>
                            <x-input-error for="title" />
                        </div>
                    </fieldset>
                    <fieldset class="space-y-2">
                        <x-label>Subtítulo</x-label>
                        <div>
                            <x-input class="w-full" name="subtitle" value="{{ old('subtitle') }}" id="subtitle" placeholder="Subtítulo" />
                            <x-input-error for="subtitle" />
                        </div>
                    </fieldset>
                    <div class="flex flex-col space-y-6 md:flex md:flex-row md:space-y-0 md:space-x-6 transition-all duration-75 ease-in-out">
                        <fieldset class="w-full space-y-2 md:w-1/2">
                            <x-label>Data</x-label>
                            <div>
                                <x-input type="date" name="date" value="{{ old('date') }}" id="date" placeholder="dd-mm-aa" />
                                <x-input-error for="date" />
                            </div>
                        </fieldset>
                        <fieldset class="w-full space-y-2 md:w-1/2">
                            <x-label>Categoria</x-label>
                            <select name="categories[]" id="categories" class="block w-full space-y-2 rounded-md border-0
                                 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset
                                  focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <option>Selecionar</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </fieldset>
                    </div>
                    <fieldset class="space-y-2">
                        <x-label>Texto</x-label>
                        <div>
                            <textarea name="summary" id="summary" rows="8" class="block w-full rounded-md border-0 py-1.5
                                 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 
                                 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">{{ old('summary') }}
                            </textarea>
                            <x-input-error for="summary" />
                        </div>
                        <p class="text-sm leading-6 text-gray-600">Escrever o corpo da notícia a publicar.</p>
                    </fieldset>
                </div>
            </div>
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <x-danger-button>Cancelar</x-danger-button>
                <x-button>Gravar</x-button>
            </div>
        </form>
    </div>
</x-appLayout>