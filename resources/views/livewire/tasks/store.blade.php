<div>
    <div class="bg-white shadow overflow-hidden sm:rounded-md mb-4">
        <ul class="divide-y divide-gray-200" x-data="{open_task:0}">
            <li>
                <a href="#"
                   x-on:click="{ open_task == -1 ? open_task=0 : open_task=-1}"
                   class="block hover:bg-gray-50">
                    <div class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-indigo-600 truncate">
                                Crear nueva tarea
                            </p>
                            <div class="ml-2 flex-shrink-0 flex">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>

                <div class="w-full px-4 my-4" x-show="open_task == -1">
                    <form wire:submit.prevent="submit(document.getElementById('id_project_always').value)"
                    x-on:submit.debounce.ms500="document.getElementById('reloadIndexTasks').click()">
                        <div class="grid sm:gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                            <div>
                                <label for="name_task_"
                                       class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ __('Name') }}
                                </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="text" id="name_task_" wire:model="name" required
                                           class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md"
                                           value="">
                                    @error('name') <span class="text-red-600">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div>
                                <label for="limit_date_task_"
                                       class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ __('Limit date') }}
                                </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="date" id="limit_date_task_" wire:model="limit_date"
                                           class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
                                </div>
                            </div>
                            <div>
                                <label for="priority_task_"
                                       class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ __('Priority') }}
                                </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">

                                    <select wire:model="priority" id="priority_task_"
                                            class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
                                        <option value="" selected="selected">
                                            Ninguna
                                        </option>
                                        <option value="1">
                                            Baja
                                        </option>
                                        <option value="2">
                                            Media
                                        </option>
                                        <option value="3">
                                            Alta
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="sm:col-span-1 md:col-span-2 lg:col-span-3 xl:col-span-3 ">
                                <label for="description_task_"
                                       class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ __('Description') }}
                                </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <textarea wire:model="description" id="description_task_" cols="30" rows="10"
                                                          class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md"
                                                ></textarea>
                                </div>
                            </div>
                            <div class="sm:col-span-1 md:col-span-2 lg:col-span-3 xl:col-span-3 ">
                                <div class="my-4">
                                    <button type="submit" class="ml-4 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Agregar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</div>
