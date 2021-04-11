<div>
    <button class="" id="editableNowRender" wire:click="reload(document.getElementById('reloadEditPanel').value)"></button>
    @if(!empty($project))
        <section @keydown.window.escape="open_editor = false;"
             x-init="$watch(&quot;open_editor&quot;, o => !o &amp;&amp;"
             x-show="open_editor" class="fixed inset-0 overflow-hidden"
             aria-labelledby="slide-over-title"
             x-ref="dialog" role="dialog" aria-modal="true">
        <div class="absolute inset-0 overflow-hidden">
            <div x-description="Background overlay, show/hide based on slide-over state."
                 class="absolute inset-0" x-on:click="open_editor = false;document.getElementById('searchNowRender').click();document.getElementById('editableNowRender').click();" aria-hidden="true"></div>

            <div class="absolute inset-y-0 pl-16 max-w-full right-0 flex">

                <div x-show="open_editor"
                     x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                     x-transition:enter-start="translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="translate-x-full" class="w-screen max-w-md"
                     x-description="Slide-over panel, show/hide based on slide-over state.">
                    <form onsubmit="return false;" class="h-full divide-y divide-gray-200 flex flex-col bg-white shadow-xl">
                        <div class="flex-1 h-0 overflow-y-auto">
                            <div class="py-6 px-4 bg-gray-900 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-lg font-medium text-white"
                                        id="slide-over-title">{{ $project->name }}</h2>
                                    <div class="ml-3 h-7 flex items-center">
                                        <button type="button"
                                                class="bg-pink-600 p-2 rounded-full text-gray-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                                                x-on:click="open_editor = false;document.getElementById('searchNowRender').click();document.getElementById('editableNowRender').click();">
                                            <span class="sr-only">Close panel</span>
                                            <svg class="h-6 w-6"
                                                 x-description="Heroicon name: outline/x"
                                                 xmlns="http://www.w3.org/2000/svg" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor"
                                                 aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <p class="text-sm text-indigo-300">{{ $project->description }}</p>
                                </div>
                            </div>
                            <div class="flex-1 flex flex-col justify-between">
                                <div class="px-4 divide-y divide-gray-200 sm:px-6">
                                    <div class="space-y-6 pt-6 pb-5">
                                        <div>
                                            <label for="project_name"
                                                   class="block text-sm font-medium text-gray-900">
                                                {{ __('Project name') }}
                                            </label>
                                            <div class="mt-1">
                                                <input type="text" wirxe:model="project_name"
                                                       x-on:keydown.debounce.50ms="document.getElementById('reloadIndexPanel').value={{ $project->id }};"
                                                       wire:keydown.debounce.500ms="updateProject(document.getElementById('project_name').getAttribute('data-id'),'name',document.getElementById('project_name').value)"
                                                       id="project_name" value="{{ $project->name }}" data-id="{{ $project->id }}"
                                                       class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
                                            </div>
                                        </div>
                                        <div>
                                            <label for="description"
                                                   class="block text-sm font-medium text-gray-900">
                                                {{ __('Description') }}
                                            </label>
                                            <div class="mt-1">
                                                                    <textarea id="description"
                                                                              x-on:keydown.debounce.50ms="document.getElementById('reloadIndexPanel').value={{ $project->id }};"
                                                                              wire:keydown.debounce.500ms="updateProject(document.getElementById('description').getAttribute('data-id'),'description',document.getElementById('description').value)"
                                                                              rows="10" data-id="{{ $project->id }}"
                                                                              class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">{{ $project->description }}</textarea>
                                            </div>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-medium text-gray-900">
                                                {{ __('Shared with') }}
                                            </h3>
                                            <div class="mt-2">
                                                <div class="flex space-x-2">

                                                    @foreach($project->sharedwith as $shared)
                                                    <button type="button" title="{{ $shared->user->name }}"
                                                       x-on:click='{id_shared={{ $shared->id }},name_shared="{{ $shared->user->name }}",open_delete_project=true}'
                                                       class="rounded-full hover:opacity-75">
                                                        <img
                                                            class="inline-block h-8 w-8 rounded-full"
                                                            src="{{ $shared->user->profile_photo_url }}"
                                                            alt="Tom Cook">
                                                    </button>
                                                    @endforeach



                                                    <button type="button"
                                                            class="flex-shrink-0 bg-white inline-flex h-8 w-8 items-center justify-center rounded-full border-2 border-dashed border-gray-200 text-gray-400 hover:text-gray-500 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        <span class="sr-only">{{ __('Share with') }}</span>
                                                        <svg class="h-5 w-5"
                                                             x-description="Heroicon name: solid/plus"
                                                             xmlns="http://www.w3.org/2000/svg"
                                                             viewBox="0 0 20 20" fill="currentColor"
                                                             aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                  d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                                  clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex-shrink-0 px-4 py-4 flex justify-end">

                            <button type="button"
                                    x-on:click="open_editor = false;document.getElementById('searchNowRender').click();document.getElementById('editableNowRender').click();"
                                    class="ml-4 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Close') }}
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
    @endif
</div>
