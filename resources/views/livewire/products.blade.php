<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    
    <div class="mt-8 text-2xl flex justify-between">
        <div>Products</div>
        <div class="mr-2">
            <x-jet-button wire:click="confirmProductAdd()" class="bg-blue-500 hover:bg-blue-700">
                Add new Product
            </x-jet-button>
        </div>
    </div>

    <div class="mt-6"> {{-- margin top of 6 --}}
        <div class="flex justify-between">
            <div>
                <input wire:model.debounce.200ms="q" type="search" placeholder="search" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
            </div>
            <div class="mr-2"> {{-- margin --}}
                <input type="checkbox" class="mr-6 leading-tight" id="expensive" wire:model="expensive" />
                <label for="expensive">Expensive only ?</label>
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
                        <td class="border px-4 py-2">{{$product->name}}</td>
                        <td class="border px-4 py-2">{{$product->prix}}</td>
                        <td class="border px-4 py-2">{{$product->stock}}</td>
                        @if($category === 'all')
                            <td class="border px-4 py-2">{{$product->categorie->name}}</td>
                        @endif
                        <td class="border px-4 py-2">
                            Edit
                            <x-jet-danger-button wire:click="confirmProductDeletion({{$product->id}})" wire:loading.attr="disabled">
                                {{ __('Delete') }}
                            </x-jet-danger-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{$products->links()}} {{-- we use pagination to show data in different pages --}}
    </div>

    <x-jet-dialog-modal wire:model="confirmingProductDeletion">
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
    </x-jet-dialog-modal>


    {{-- adding a new product --}}
    <x-jet-dialog-modal wire:model="confirmingProductAdd">
        <x-slot name="title">
            {{ __('Add Product') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Form') }}
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
            <x-jet-input id="price" type="number" min="0" class="mt-1 block w-full" wire:model.defer="product.price" />
            <x-jet-input-error for="product.price" class="mt-2" />
            {{-- stock --}}
            <x-jet-label for="stock" value="{{ __('Stock') }}" />
            <x-jet-input id="stock" type="number" min="0" class="mt-1 block w-full" wire:model.defer="product.stock" />
            <x-jet-input-error for="product.stock" class="mt-2" />
            {{-- category --}}
            <x-jet-label for="cat_id" value="{{ __('Category') }}" />
            <select id="cat-id" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" wire:model.defer="product.category">
                <option value="" selected>Choose here</option>
                @foreach ($categories as $cat)
                    <option value="{{$cat->id}}">
                        {{$cat->name}}
                    </option>
                @endforeach
            </select>
            <x-jet-input-error for="product.category" class="mt-2" />
        </x-slot>

        <x-slot name="footer">
            {{-- on cancel, make the flag false again --}}
            <x-jet-secondary-button wire:click="$set('confirmingProductAdd', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
            {{-- the flag holds in the product id --}}
            <x-jet-danger-button class="ml-3" wire:click="saveProduct()" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
