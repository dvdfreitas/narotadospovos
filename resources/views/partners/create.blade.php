<x-appLayout>
    <div class="max-w-md m-auto px-4 my-10 sm:px-0 sm:max-w-xl md:max-w-2xl lg:max-w-4xl xl:max-w-6xl 
    xl:mx-20 2xl:max-w-full transition-all duration-75 ease-in-out">
        <form method="POST" action="/partners" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-flow-row gap-6 lg:grid lg:grid-cols-2 transition-all duration-75 ease-in-out">
                <div class="col-span-1 space-y-10 border-gray-900/25">
                    <header class="flex flex-col space-y-2 justify-center">
                        <h4 class="font-black text-base text-[#0083b3] uppercase">
                            Se der um pouco vai faltar menos.
                        </h4>
                        <h1 class="font-normal text-lg md:text-3xl uppercase">
                            Neste processo de fazer do mundo um lugar melhor, todos contam.
                        </h1>
                    </header>
                    <p class="">
                        Não estamos sozinhos, nesta busca por um mundo melhor, mais justo e inclusivo,
                        onde o ser humano e o meio ambiente são centro das atenções. Temos vários parceiros
                        que colaboram connosco, contribuindo de forma direta e direta no desenvolvimento da
                        na missão.
                    </p>
                </div>
                <div class="col-span-1 rounded-lg lg:shadow-md">
                    <div class="font-medium text-xs text-gray-400 rounded-t-lg p-6 uppercase bg-gray-50">
                        <h1>Torne-se Parceiro</h1>
                    </div>
                    <div class="flex flex-row p-8 border-b border-gray-900/10">
                        <div class="flex flex-col w-full space-y-3 items-center">
                            <div class="flex flex-col w-full items-center">
                                <div class="relative w-24 h-24 flex flex-col p-4 justify-center border border-dashed
                                border-gray-900/25 items-center bg-gray-900/25 rounded-full lg:h-36 lg:w-36 overflow-hidden">
                                    <svg class="object-cover object-center text-gray-300" 
                                        viewBox="0 0 24 24" 
                                        fill="currentColor" 
                                        aria-hidden="true">
                                        <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 
                                        6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 
                                        0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 
                                        0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" 
                                        clip-rule="evenodd" />
                                    </svg>  
                                    <div class="absolute inset-0 z-50 flex justify-center items-center text-sm leading-6 text-gray-600">
                                        <label for="file-upload" 
                                            class="flex w-full h-full justify-center items-center cursor-pointer rounded-full
                                            bg-blue-500/45 text-white font-semibold hover:bg-blue-600/55 focus:outline-none 
                                            focus:ring-2 focus:ring-blue-500">
                                            <span class="font-black text-xs text-center">Upload de logotipo</span>
                                            <input type="file" 
                                                name="logo" 
                                                id="file-upload" 
                                                class="sr-only" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full space-y-6">
                                <fieldset class="flex flex-col w-full space-y-2">
                                    <x-label class="flex justify-start items-center">
                                        Nome
                                        <span class="text-red-600 ml-2">
                                            *
                                        </span>
                                    </x-label>
                                    <div>
                                        <x-input id="name" 
                                        class="block mt-1 w-full text-xs placeholder-gray-300" 
                                        type="text" name="name" 
                                        value="{{old('name')}}" 
                                        placeholder="Mundo Melhor" 
                                        required autofocus />
                                        <x-input-error for="name" />
                                    </div>
                                </fieldset>
                                <div class="flex flex-col space-y-6 md:flex md:flex-row 
                                md:space-y-0 md:space-x-6 transition-all duration-75 ease-in-out">
                                    <fieldset class="w-full space-y-2">
                                        <x-label class="flex justify-start items-center">
                                            Website
                                            <span class="text-gray-600 ml-2">
                                                ( Opcional )
                                            </span>
                                        </x-label>
                                        <div>
                                            <x-input id="website" 
                                            class="block mt-1 w-full text-xs placeholder-gray-300" 
                                            type="url" 
                                            name="website" 
                                            value="{{old('website')}}" 
                                            placeholder="https://www.mundomelhor.org" 
                                            autofocus />
                                            <x-input-error for="website" />
                                        </div>
                                    </fieldset>
                                    <fieldset class="w-full space-y-2">
                                        <x-label class="flex justify-start items-center">
                                            Facebook
                                            <span class="text-gray-600 ml-2">
                                                ( Opcional )
                                            </span>
                                        </x-label>
                                        <div>
                                            <x-input id="facebook" 
                                            class="block mt-1 w-full text-xs placeholder-gray-300" 
                                            type="url" 
                                            name="facebook" 
                                            value="{{old('facebook')}}" 
                                            placeholder="https://www.facebook.com/mundomelhor" 
                                            autofocus />
                                            <x-input-error for="facebook" />
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="flex flex-col space-y-6 md:flex md:flex-row 
                                md:space-y-0 md:space-x-6 transition-all duration-75 ease-in-out">
                                    <fieldset class="w-full space-y-2">
                                        <x-label class="flex justify-start items-center">
                                            Instagram
                                            <span class="text-gray-600 ml-2">
                                                ( Opcional )
                                            </span>
                                        </x-label>
                                        <div>
                                            <x-input id="instagram" 
                                            class="block mt-1 w-full text-xs placeholder-gray-300" 
                                            type="url" name="instagram" 
                                            value="{{old('instagram')}}" 
                                            placeholder="https://www.instagram.com/mundomelhor" 
                                            autofocus />
                                            <x-input-error for="instagram" />
                                        </div>
                                    </fieldset>
                                    <fieldset class="w-full space-y-2">
                                        <x-label class="flex justify-start items-center">
                                            LinkedIn
                                            <span class="text-gray-600 ml-2">
                                                ( Opcional )
                                            </span>
                                        </x-label>
                                        <div>
                                            <x-input id="linkedIn" 
                                            class="block mt-1 w-full text-xs placeholder-gray-300" 
                                            type="url" name="linkedIn" 
                                            value="{{old('linkedIn')}}" 
                                            placeholder="https://www.linkedin.com/mundomelhor" 
                                            autofocus />
                                            <x-input-error for="linkedIn" />
                                        </div>
                                    </fieldset>
                                </div>              
                                <div class="flex flex-col space-y-4 text-xs">
                                    <span class="block text-gray-700 font-semibold">Deseja que o parceiro seja publicado?</span>
                                    <div class="flex space-x-4 items-center">
                                        <div class="flex space-x-2 justify-center">
                                            <input 
                                            type="radio" 
                                            id="visible-yes" 
                                            name="visible" 
                                            value="1" 
                                            {{ old('visible') == '1' ? 'checked' : ''}}
                                            required>
                                            <label for="visible-yes" class="text-gray-700">Sim</label>
                                        </div>
                                        <div class="flex space-x-2 justify-center">
                                            <input 
                                            type="radio" 
                                            id="visible-no" 
                                            name="visible" 
                                            value="0" 
                                            {{ old('visible') == '0' ? 'checked' : ''}}
                                            required>
                                            <label for="visible-no" class="text-gray-700">Não</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center md:justify-end space-x-6 p-8">
                        <x-danger-button>Cancelar</x-danger-button>
                        <x-button>Gravar</x-button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-appLayout>