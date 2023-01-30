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
            <div>
                @if(Auth()->user()->utype === 'SAD')
                    Clients and Admins
                @else
                    Clients
                @endif
            </div>
        </div>
    </div>

    <div class="mt-6"> {{-- margin top of 6 --}}
        <div class="flex justify-between">
            <div>
                <input wire:model.debounce.200ms="q" type="search" placeholder="search" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
            </div>
            @if(Auth()->user()->utype === 'SAD')
                <div class="mr-2"> {{-- margin --}}
                    <input type="checkbox" class="mr-6 leading-tight" id="clients" wire:model="clients" />
                    <label for="clients">Clients only</label>
                </div>
            @endif

            <div class="mr-2"> {{-- margin --}}
                <input type="checkbox" class="mr-6 leading-tight" id="active" wire:model="active" />
                <label for="active">Active only</label>
            </div>
            
            
        </div>
        <table class="table-auto w-full"> {{-- full width --}}
            <thead>
                <tr>
                    <th class="px-4 py-2"> {{-- padding x of 4 --}}
                        <div class="flex items-center">
                            <button wire:click="sortBy('id')">ID</button>
                            <x-sort-icon sortField="id" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    <th class="px-4 py-2"> {{-- padding x of 4 --}}
                        <div class="flex items-center">
                            <button wire:click="sortBy('name')">Name</button>
                            <x-sort-icon sortField="name" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    <th class="px-4 py-2"> {{-- padding x of 4 --}}
                        <div class="flex items-center">
                            <button wire:click="sortBy('email')">Email</button>
                            <x-sort-icon sortField="email" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    @if(Auth()->user()->utype === 'SAD')
                        <th class="px-4 py-2"> {{-- padding x of 4 --}}
                            Type
                        </th>
                    @endif
                    <th class="px-4 py-2"> {{-- padding x of 4 --}}
                        Status
                    </th>
                    <th class="px-4 py-2"> {{-- padding x of 4 --}}
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                    <tr>
                        <td class="border px-4 py-2">{{$u->id}}</td>
                        <td class="border px-4 py-2">
                            <div class="flex flex-row items-center flex-wrap">
                                <div class="mr-2" x-show="! photoPreview">
                                    <img src="{{ $u->profile_photo_url }}" alt="{{ $u->name }}" class="rounded-full h-8 w-8 object-cover">
                                </div>
                            
                                {{$u->name}}
                            </div>
                        </td>
                        <td class="border px-4 py-2">{{$u->email}}</td>
                        @if(Auth()->user()->utype === 'SAD')
                            <td class="border px-4 py-2">
                                @if($u->utype ==='ADM')
                                    Admin
                                @else
                                    Client
                                @endif
                            </td>
                        @endif
                        <td class="border px-4 py-2 text-center">
                            @if($u->utype==='USR')
                                @if($u->banned)
                                    Banned
                                @else
                                    Not Banned
                                @endif
                            @else
                                ---
                            @endif
                        </td>
                        <td class="border px-4 py-2 ">
                            <div class="flex justify-center w-full">
                                <x-jet-button wire:click="confirmUserEmail({{$u->id}})" class="mr-6 mb-2 bg-orange-500 hover:bg-orange-700" wire:loading.attr="disabled">
                                    {{ __('Email') }}
                                </x-jet-button>
                                @if($u->utype==='USR')
                                    <x-jet-danger-button class="mr-6 mb-2" wire:click="confirmUserBan({{$u->id}})" wire:loading.attr="disabled">
                                        {{ $u->banned ? __('Unban') :  __('Ban')}}
                                    </x-jet-danger-button>
                                    
                                @endif
                                @if(Auth()->user()->utype === 'SAD')
                                    @if($u->utype==='USR' && !$u->banned)
                                        <x-jet-danger-button class="mr-6 mb-2" wire:click="confirmUserPromotion({{$u->id}})" wire:loading.attr="disabled">
                                            {{ __('Promote') }}
                                        </x-jet-danger-button>
                                    @endif
                                    @if($u->utype==='ADM')
                                        <x-jet-danger-button class="mr-6 mb-2" wire:click="confirmUserPromotion({{$u->id}})" wire:loading.attr="disabled">
                                            {{ __('Demote') }}
                                        </x-jet-danger-button>
                                    @endif
                                @endif
                                <x-jet-danger-button class="mb-2" wire:click="confirmUserDeletion({{$u->id}})" wire:loading.attr="disabled">
                                    {{ __('Delete') }}
                                </x-jet-danger-button>

                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{$users->links()}} {{-- we use pagination to show data in different pages --}}
    </div>

    <x-jet-confirmation-modal wire:model="confirmingUserDeletion">
        <x-slot name="title">
            {{ __('Delete User') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this user?') }}

        </x-slot>

        <x-slot name="footer">
            {{-- on cancel, make the flag false again --}}
            <x-jet-secondary-button wire:click="$set('confirmingUserDeletion', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
            {{-- the flag holds in the user id --}}
            <x-jet-danger-button class="ml-3" wire:click="deleteUser({{$confirmingUserDeletion}})" wire:loading.attr="disabled">
                {{ __('Delete User') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <x-jet-confirmation-modal wire:model="confirmingUserBan">
        <x-slot name="title">
            {{ $this->banned ? 'Unban user' : 'Ban user' }}
        </x-slot>

        <x-slot name="content">
            {{ $this->banned ? __('Are you sure you want to unban this user?') :  __('Are you sure you want to ban this user?')}}

        </x-slot>

        <x-slot name="footer">
            {{-- on cancel, make the flag false again --}}
            <x-jet-secondary-button wire:click="$set('confirmingUserBan', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
            {{-- the flag holds in the user id --}}
            <x-jet-danger-button class="ml-3" wire:click="banUser({{$confirmingUserBan}})" wire:loading.attr="disabled">
                {{ $this->banned ? __('Unban User') :  __('Ban User')}}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <x-jet-confirmation-modal wire:model="confirmingUserPromotion">
        <x-slot name="title">
            {{ $this->utype==='USR' ? 'Promote Client' : 'Demote Admin' }}
        </x-slot>

        <x-slot name="content">
            {{ $this->utype==='USR' ? __('Are you sure you want to promote this client?') :  __('Are you sure you want to demote this admin?')}}
        </x-slot>

        <x-slot name="footer">
            {{-- on cancel, make the flag false again --}}
            <x-jet-secondary-button wire:click="$set('confirmingUserPromotion', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
            {{-- the flag holds in the user id --}}
            <x-jet-danger-button class="ml-3" wire:click="promoteUser({{$confirmingUserPromotion}})" wire:loading.attr="disabled">
                {{ $this->utype==='USR' ? __('Promote') :  __('Demote')}}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    {{-- Emails --}}
    <x-jet-dialog-modal wire:model="confirmingUserEmail">
        <x-slot name="title">
            Email
        </x-slot>

        <x-slot name="content">
            {{-- Object --}}
            <x-jet-label for="object" value="{{ __('Object') }}" />
            <x-jet-input id="object" type="text" class="mt-1 block w-full" wire:model.defer="mail.object" />
            <x-jet-input-error for="mail.object" class="mt-2" />
            {{-- content --}}
            <x-jet-label for="content" value="{{ __('Content') }}" />
            <textarea id="content" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" wire:model.defer="mail.content" ></textarea>
            <x-jet-input-error for="mail.content" class="mt-2" />
            {{-- Photo --}}
            <x-jet-label for="file" value="{{ __('Attach file') }}" />
            <input id="file" class="mt-2 mr-2"
             type="file"
              wire:model.defer="file"
               value="{{ __('Attach file ?') }}" />
        </x-slot>

        <x-slot name="footer">
            {{-- on cancel, make the flag false again --}}
            <x-jet-secondary-button wire:click="$set('confirmingUserEmail', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
            {{-- the flag holds in the user id --}}
            <x-jet-danger-button class="ml-3 bg-green-500 hover:bg-green-700" wire:click="emailUser({{$confirmingUserEmail}})" wire:loading.attr="disabled">
                Email User
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>

