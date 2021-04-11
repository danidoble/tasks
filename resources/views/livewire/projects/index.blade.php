<div>
    <div class="relative pt-0 pb-4 px-4 sm:px-6 lg:pt-0 lg:pb-4 lg:px-8">
        <div class="absolute inset-0">
            <div class=" h-1/3 sm:h-2/3"></div>
        </div>
        <div class="relative max-w-7xl mx-auto">
            <button class="" id="searchNowRender" wire:click="reload()"></button>
            <input wire:model="search" type="search" class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md mb-3" placeholder="{{ __('Search') }}">
            <div
                class="mt-0 max-w-lg mx-auto grid gap-3 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 lg:max-w-none">
                @foreach($projects as $project)
                    <div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
                        @if(intval($project->user_id) === intval(Auth::user()->id))
                        <div class="w-full flex justify-end">
                            <button class="absolute inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-transparent hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                x-on:click='{open_editor=true;id_project={{ $project->id }}};document.getElementById("reloadEditPanel").value={{ $project->id }};document.getElementById("editableNowRender").click();'>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                        @endif
                        <a href="{{ route('projects.show',['id'=>$project->id]) }}" class="flex-1 bg-white p-6 flex flex-col justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-indigo-600">
                                    <span class="text-xl font-semibold text-gray-900">
                                        {{ $project->name }}
                                    </span>
                                </p>
                                <div class="block mt-2">
                                    <p class="mt-3 text-xs text-gray-500">
                                        {{ $project->description }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-6 flex items-center">
                                <div>
                                <div class="flex">
                                    <div class="align-bottom">
                                        <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition align-bottom">
                                            <img class="h-8 w-8 rounded-full object-cover align-bottom" src="{{ $project->user->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                        </button>
                                    </div>
                                    <div class="grid items-center ml-2">
                                    <p class="text-sm font-medium text-gray-900 align-bottom">
                                        <span class="text-blue-700">
                                            {{ __('Created by') }} {{ $project->user->name }}
                                        </span>
                                    </p>
                                    </div>
                                </div>
                                    <div class="flex text-xs text-gray-500">
                                        <time datetime="{{ $project->created_at }}" class="text-blue-500">
                                            {!! $project->created_at !== null ? 'El '.\App\Http\Controllers\AuxController::diffForHumans($project->created_at) : __('Date?') !!}
                                            {{ $project->created_at !== null ? 'a las '.date('H:i',strtotime($project->created_at)) : __('Hour?') }}
                                        </time>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{ $projects->links() }}


</div>
