<div>
    <form wire:submit.prevent="saveProject"
          x-on:submit.debounce.100ms="document.getElementById('searchNowRender').click();">
        <div class="grid grid-cols-1">
            <div>
                <label for="project_name_new"
                       class="block text-sm font-medium text-gray-900">
                    {{ __('Project name') }}
                </label>
                <div class="mt-1">
                    <input type="text" wire:model.debounce.500ms="name" id="project_name_new"
                           class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
                    <div>
                        @error('name') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div>
                <label for="description_new"
                       class="block text-sm font-medium text-gray-900">
                    {{ __('Description') }}
                </label>
                <div class="mt-1">
                    <textarea wire:model.debounce.500ms="description" id="description_new" cols="30" rows="10"
                              class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md"></textarea>
                    <div>
                        @error('description') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div>
                <div class="my-4">
                    <button type="submit"
                            class="ml-4 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Guardar projecto
                    </button>
                </div>
            </div>
        </div>


    </form>
</div>
