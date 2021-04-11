<div>
    <button id="reloadIndexTasks" wire:click="reload" class="hidden"></button>
    @if(!empty($tasks) && count($tasks) > 0)
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="" x-data="{open_task:0}">
                @foreach($tasks as $task)
                    <li class="border-l-4 @if(intval($task->priority) === 1) border-blue-600 @elseif(intval($task->priority) === 2) border-yellow-600 @elseif(intval($task->priority) === 3) border-red-600 @else border-gray-100 @endif">
                        <div class="grid grid-cols-12">
                            @if(intval($task->user_id) === intval(Auth::user()->getAuthIdentifier()))
                            <div class="col-span-1 w-full">
                                <div class="w-full">
                                    <div class="w-full grid justify-center pt-4">
                                        <div class="p-0 m-0 w-full inline-flex flex-wrap items-center">
                                            <input id="comments" name="comments" type="checkbox"
                                                   x-on:click="document.getElementById('id_task_selected').value = {{ $task->id }};"
                                                   wire:click.debounce.ms200="complete(document.getElementById('id_task_selected').value)"
                                                   class="focus:ring-indigo-500 h-6 w-6 text-indigo-600 border-gray-300 rounded">

                                            <button class="ml-1 inline-flex justify-center text-sm py-1 px-1 border border-transparent shadow-sm text-sm font-medium rounded-full text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                                    x-on:click="document.getElementById('id_task_selected').value = {{ $task->id }};"
                                                    wire:click.debounce.ms200="delete(document.getElementById('id_task_selected').value)">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            @endif
                            <a href="#"
                               x-on:click="{ open_task == {{ $task->id }} ? open_task=0 : open_task={{ $task->id }}};document.getElementById('id_task_selected').value = {{ $task->id }}"
                               class="block hover:bg-gray-50 @if(intval($task->user_id) === intval(Auth::user()->getAuthIdentifier())) col-span-11 @else col-span-12 @endif">
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-medium text-indigo-600 truncate">
                                            {{ $task->name }}
                                        </p>
                                        <div class="ml-2 flex-shrink-0 flex">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                 viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="mt-2 sm:flex sm:justify-between">
                                        <div class="sm:flex">
                                            <p class="flex items-center text-xs text-gray-500">
                                                <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400"
                                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                     fill="currentColor" aria-hidden="true">
                                                    <path
                                                        d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                                </svg>
                                                {{ __('Created by') }} {{ $task->user->name }}
                                            </p>
                                        </div>
                                        @if($task->limit_date !== null)
                                            <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                                <!-- Heroicon name: solid/calendar -->
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                     fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                          d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                          clip-rule="evenodd"/>
                                                </svg>
                                                <p>
                                                    <time datetime="{{ $task->limit_date }}">
                                                        Limite {{ $task->limit_date !== null ? \App\Http\Controllers\AuxController::diffForHumans($task->limit_date) : '' }}</time>
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="w-full px-4 my-4" x-show="open_task == {{ $task->id }}">
                            <div
                                class="grid sm:gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                                <div>
                                    <label for="name_task_{{ $task->id }}"
                                           class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ __('Name') }}
                                    </label>
                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <input type="text" id="name_task_{{ $task->id }}" name="name"
                                               data-id="{{ $task->id }}"
                                               wire:keydown.debounce.500ms="updateTask(document.getElementById('name_task_{{ $task->id }}').getAttribute('data-id'),'name',document.getElementById('name_task_{{ $task->id }}').value)"
                                               class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md"
                                               value="{{ $task->name }}">
                                    </div>
                                </div>
                                <div>
                                    <label for="limit_date_task_{{ $task->id }}"
                                           class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ __('Limit date') }}
                                    </label>
                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <input type="date" id="limit_date_task_{{ $task->id }}"
                                               data-id="{{ $task->id }}"
                                               wire:change.debounce.500ms="updateTask(document.getElementById('limit_date_task_{{ $task->id }}').getAttribute('data-id'),'limit_date',document.getElementById('limit_date_task_{{ $task->id }}').value)"
                                               name="limit_date"
                                               class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md"
                                               value="{{ $task->limit_date !== null ? date('Y-m-d',strtotime($task->limit_date)) : '' }}">
                                    </div>
                                </div>
                                <div>
                                    <label for="priority_task_{{ $task->id }}"
                                           class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ __('Priority') }}
                                    </label>
                                    <div class="mt-1 sm:mt-0 sm:col-span-2">

                                        <select name="priority" id="priority_task_{{ $task->id }}"
                                                data-id="{{ $task->id }}"
                                                wire:change.debounce.500ms="updateTask(document.getElementById('priority_task_{{ $task->id }}').getAttribute('data-id'),'priority',document.getElementById('priority_task_{{ $task->id }}').value)"
                                                class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
                                            <option
                                                value="" {{ ($task->priority === null || intval($task->priority) === 0) ? 'selected="selected"' : '' }}>
                                                Ninguna
                                            </option>
                                            <option
                                                value="1" {{ (intval($task->priority) === 1) ? 'selected="selected"' : '' }}>
                                                Baja
                                            </option>
                                            <option
                                                value="2" {{ (intval($task->priority) === 2) ? 'selected="selected"' : '' }}>
                                                Media
                                            </option>
                                            <option
                                                value="3" {{ (intval($task->priority) === 3) ? 'selected="selected"' : '' }}>
                                                Alta
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="sm:col-span-1 md:col-span-2 lg:col-span-3 xl:col-span-3 ">
                                    <label for="description_task_{{ $task->id }}"
                                           class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ __('Description') }}
                                    </label>
                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <textarea name="description" id="description_task_{{ $task->id }}"
                                                          cols="30" rows="10"
                                                          data-id="{{ $task->id }}"
                                                          wire:keydown.debounce.500ms="updateTask(document.getElementById('description_task_{{ $task->id }}').getAttribute('data-id'),'description',document.getElementById('description_task_{{ $task->id }}').value)"
                                                          class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md"
                                                >{{ $task->description }}</textarea>
                                    </div>
                                </div>
                                <div class="sm:col-span-1 md:col-span-2 lg:col-span-3 xl:col-span-3 ">
                                    <div class="my-4">
                                        @if(intval($task->user_id) === intval(Auth::user()->getAuthIdentifier()))
                                        <button
                                            class="ml-4 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                            wire:click="complete(document.getElementById('id_task_selected').value)">
                                            Completado
                                        </button>

                                        <button
                                            class="ml-4 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                            wire:click="delete(document.getElementById('id_task_selected').value)">
                                            Eliminar
                                        </button>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        {{ $tasks->links() }}
    @else
        <div class="bg-transparent shadow-none overflow-hidden sm:rounded-md">
            <div class="bg-transparent overflow-hidden shadow-none rounded-lg ">
                <div class="px-4 py-5 sm:px-6">
                    <img src="{{ asset('img/icons/in-love.svg') }}" class="mx-auto w-20 h-20"
                         alt="In love emoji">
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="w-full text-center text-3xl text-gray-800">
                        Parece que no hay nada pendiente por aqu&iacute;.
                    </div>
                    <div class="w-full text-center text-2xl text-gray-500">
                        Mientras tanto, difunda el amor.
                    </div>
                    <div class="w-full text-center text-xs text-gray-400">
                        (Si, me lo robe de las tareas de ubuntu...)
                    </div>
                </div>
            </div>

        </div>
    @endif
</div>
