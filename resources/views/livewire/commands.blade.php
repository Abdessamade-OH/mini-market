<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    <div class="flex justify-between flex-col">
        @if(session()->has('message'))
        <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3 relative" role="alert" x-data="{show: true}" x-show="show">
            <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
            <p>{{ session('message') }}</p>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3" @click="show = false">
                <svg class="fill-current h-6 w-6 text-white" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
        </div>
        @endif

        <div class="mt-8 text-2xl flex justify-between">
            <div>Commands</div>
        </div>
    </div>

    <div class="mt-6"> {{-- margin top of 6 --}}
        <div class="flex justify-between">
            <div>
                <input wire:model.debounce.200ms="q" type="search" placeholder="search" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
            </div>
            
        </div>
        <table class="table-auto w-full"> {{-- full width --}}
            <thead>
                <tr>
                    <th class="px-4 py-2"> {{-- padding x of 4 --}}
                        <div class="flex items-center">
                            <button wire:click="sortBy('id')">Client ID</button>
                            <x-sort-icon sortField="id" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    <th class="px-4 py-2"> {{-- padding x of 4 --}}
                        <div class="flex items-center">
                            <button wire:click="sortBy('name')">Client Name</button>
                            <x-sort-icon sortField="name" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    <th class="px-4 py-2"> {{-- padding x of 4 --}}
                        Command
                    </th>
                    <th class="px-4 py-2"> {{-- padding x of 4 --}}
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                
                @foreach($clients as $client)
                
                    <tr>
                        <td class="border px-4 py-2">{{$client->id}}</td>
                        <td class="border px-4 py-2">
                            {{$client->name}}
                        </td>
                        <td class="border px-4 py-2">
                            @if($client->products->count())
                                <table class="table-auto w-full"> {{-- full width --}}
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2"> {{-- padding x of 4 --}}
                                                Command ID
                                            </th>
                                            <th class="px-4 py-2"> {{-- padding x of 4 --}}
                                                Product ID
                                            </th>
                                            <th class="px-4 py-2"> {{-- padding x of 4 --}}
                                                Product Name
                                            </th>
                                            <th class="px-4 py-2"> {{-- padding x of 4 --}}
                                                Quantity
                                            </th>
                                            <th class="px-4 py-2"> {{-- padding x of 4 --}}
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach($client->products as $product)
                                        
                                            <tr>
                                                <td class="border px-4 py-2">{{$product->pivot->id}}</td>
                                                <td class="border px-4 py-2">{{$product->id}}</td>
                                                <td class="border px-4 py-2">
                                                    {{$product->name}}
                                                </td>
                                                <td class="border px-4 py-2">
                                                    {{$product->pivot->quantity}}
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <div class="flex justify-center">
                                                        <x-jet-button wire:click="confirmCommandEdit({{$product->pivot->id}}, {{$product->stock}})" class="mr-6 bg-orange-500 hover:bg-orange-700">
                                                            Edit
                                                        </x-jet-button>
                                                        
                                                        <x-jet-danger-button wire:click="confirmCommandDeletion({{$client->id}}, {{$product->pivot->id}})" wire:loading.attr="disabled">
                                                            {{ __('Delete') }}
                                                        </x-jet-danger-button>
                                                    </div>  
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <strong>No Commands for this client</strong>
                            @endif
                        </td>
                        <td class="border px-4 py-2">
                            @if($client->products->count())
                                <div class="flex justify-center">
                                    <x-jet-danger-button wire:click="confirmCommandAllDeletion({{$client->id}})" wire:loading.attr="disabled">
                                        {{ __('Delete All') }}
                                    </x-jet-danger-button>
                                </div>
                            @else
                            <div class="flex justify-center">
                                ---
                            </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{$clients->links()}} {{-- we use pagination to show data in different pages --}}
    </div>

    <x-jet-confirmation-modal wire:model="confirmingCommandDeletion">
        <x-slot name="title">
            {{ __('Delete Command') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this command?') }}

        </x-slot>

        <x-slot name="footer">
            {{-- on cancel, make the flag false again --}}
            <x-jet-secondary-button wire:click="$set('confirmingCommandDeletion', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
            {{-- the flag holds in the Category id --}}
            <x-jet-danger-button class="ml-3" wire:click="deleteCommand()" wire:loading.attr="disabled">
                {{ __('Delete Command') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <x-jet-confirmation-modal wire:model="confirmingCommandAllDeletion">
        <x-slot name="title">
            {{ __('Delete all Commands for client') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete all the commands for this client?') }}

        </x-slot>

        <x-slot name="footer">
            {{-- on cancel, make the flag false again --}}
            <x-jet-secondary-button wire:click="$set('confirmingCommandAllDeletion', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
            {{-- the flag holds in the Category id --}}
            <x-jet-danger-button class="ml-3" wire:click="deleteAllCommands({{$confirmingCommandAllDeletion}})" wire:loading.attr="disabled">
                {{ __('Delete Command') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>


    <x-jet-dialog-modal wire:model="confirmingCommandEdit">
        <x-slot name="title">
            Edit command quantity
        </x-slot>

        <x-slot name="content">
            <x-jet-label for="quantity" value="{{ __('Quantity') }}" />
            <x-jet-input min="1" id="quantity" type="number" class="mt-1 block w-full" wire:model.defer="quantity" />
            <x-jet-input-error for="quantity" class="mt-2" />
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingCommandEdit', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
            <x-jet-danger-button class="ml-3 bg-green-500 hover:bg-green-700" wire:click="saveCommand()" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
