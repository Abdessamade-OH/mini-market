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
            <div>Products</div>
            <div class="mr-2">
                <x-jet-button wire:click="confirmProductAdd()" class="bg-blue-500 hover:bg-blue-700">
                    Add new Product
                </x-jet-button>
            </div>
        </div>
    </div>

    <div class="mt-6 "> {{-- margin top of 6 --}}
        <div class="flex justify-between">
            <div>
                <input wire:model.debounce.200ms="q" type="search" placeholder="search" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
            </div>
            <div class="mr-2"> {{-- margin --}}
                <input type="checkbox" class="mr-6 leading-tight" id="onStock" wire:model="onStock" />
                <label for="onStock">on stock only</label>
            </div>
            <div class="mr-2"> {{-- margin --}}
                <label for="category">Category
                    <select class="mr-6 leading-tight" id="category" wire:model="category">
                            <option value="all" default>All</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{$cat->name}}</option>
                        @endforeach
                    </select>
                </label>
            </div>
        </div>

        <table class="table-auto w-full "> {{-- full width --}}
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
                            <button wire:click="sortBy('prix')">Price</button>
                            <x-sort-icon sortField="prix" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    <th class="px-4 py-2"> {{-- padding x of 4 --}}
                        <div class="flex items-center">
                            <button wire:click="sortBy('stock')">Stock</button>
                            <x-sort-icon sortField="stock" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    @if($category === 'all')
                        <th class="px-4 py-2"> {{-- padding x of 4 --}}
                            Category
                        </th>
                    @endif
                    <th class="px-4 py-2"> {{-- padding x of 4 --}}
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td class="border px-4 py-2">{{$product->id}}</td>
                        <td class="border px-4 py-2">
                            
                            <div class="flex flex-row items-center flex-wrap">
                                <div class="mr-2">
                                    <img src="{{ $product->image_path }}" alt="Pic " class="rounded-full h-8 w-8 object-cover">
                                </div>
                            
                                {{$product->name}}
                            </div>
                        </td>
                        <td class="border px-4 py-2">{{$product->prix}}</td>
                        <td class="border px-4 py-2">{{$product->stock}}</td>
                        @if($category === 'all')
                            <td class="border px-4 py-2">{{$product->categorie->name}}</td>
                        @endif
                        <td class="border px-4 py-2">
                            <div class="flex justify-center">
                                <x-jet-button wire:click="confirmProductEdit({{$product->id}})" class="mr-6 bg-orange-500 hover:bg-orange-700">
                                    Edit
                                </x-jet-button>
                                <x-jet-danger-button wire:click="confirmProductDeletion({{$product->id}})" wire:loading.attr="disabled">
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
        {{$products->links()}} {{-- we use pagination to show data in different pages --}}
    </div>

    <x-jet-confirmation-modal wire:model="confirmingProductDeletion">
        <x-slot name="title">
            {{ __('Delete Product') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this product?') }}

        </x-slot>

        <x-slot name="footer">
            {{-- on cancel, make the flag false again --}}
            <x-jet-secondary-button wire:click="$set('confirmingProductDeletion', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
            {{-- the flag holds in the product id --}}
            <x-jet-danger-button class="ml-3" wire:click="deleteProduct({{$confirmingProductDeletion}})" wire:loading.attr="disabled">
                {{ __('Delete Product') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>


    {{-- adding a new product --}}
    <x-jet-dialog-modal wire:model="confirmingProductAdd">
        <x-slot name="title">
            {{ isset( $this->product->id) ? 'Edit product' : 'Add product' }}
        </x-slot>

        <x-slot name="content">
            {{-- name --}}
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="product.name" />
            <x-jet-input-error for="product.name" class="mt-2" />
            {{-- description --}}
            <x-jet-label for="desc" value="{{ __('Description') }}" />
            <textarea id="desc" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" wire:model.defer="product.description" ></textarea>
            <x-jet-input-error for="product.description" class="mt-2" />
            {{-- price --}}
            <x-jet-label for="price" value="{{ __('Price') }}" />
            <x-jet-input id="price" type="number" min="0" class="mt-1 block w-full" wire:model.defer="product.prix" />
            <x-jet-input-error for="product.prix" class="mt-2" />
            {{-- stock --}}
            <x-jet-label for="stock" value="{{ __('Stock') }}" />
            <x-jet-input id="stock" type="number" min="0" class="mt-1 block w-full" wire:model.defer="product.stock" />
            <x-jet-input-error for="product.stock" class="mt-2" />
            {{-- category --}}
            <x-jet-label for="cat_id" value="{{ __('Category') }}" />
            <select id="cat-id" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" wire:model.defer="product.categorie_id">
                <option value="" selected>Choose here</option>
                @foreach ($categories as $cat)
                    <option value="{{$cat->id}}">
                        {{$cat->name}}
                    </option>
                @endforeach
            </select>
            <x-jet-input-error for="product.categorie_id" class="mt-2" />
            {{-- Photo --}}
            <x-jet-label for="photo" value="{{ __('Photo') }}" />
            <input id="photo" class="mt-2 mr-2"
             type="file" accept="image/png, image/jpeg"
              wire:model.defer="photo" wire:click=""
               value="{{ __('Select A New Photo') }}" />

            {{-- comment @if (isset( $this->product->id))
                @if($this->product->image_path !== "/storage/defaultImage.png")
                    <x-jet-secondary-button type="button" class="mt-2" wire:click="">
                        {{ __('Remove Photo') }}
                    </x-jet-secondary-button>
                @endif
            @endif
            <x-jet-input-error for="photo" class="mt-2" />--}}
        </x-slot>

        <x-slot name="footer">
            {{-- on cancel, make the flag false again --}}
            <x-jet-secondary-button wire:click="$set('confirmingProductAdd', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
            {{-- the flag holds in the product id --}}
            <x-jet-danger-button class="ml-3 bg-green-500 hover:bg-green-700" wire:click="saveProduct()" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>

    
</div>
