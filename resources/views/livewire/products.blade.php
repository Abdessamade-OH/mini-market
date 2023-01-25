<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    <div class="mt-8 text-2xl">
        Products
    </div>

    <div class="mt-6"> {{-- margin top of 6 --}}
        <div class="flex justify-between">
            <div></div>
            <div class="mr-2"> {{-- margin --}}
                <input type="checkbox" class="mr-6 leading-tight" id="expensive" />
                <label for="expensive">Expensive only ?</label>
            </div>
        </div>
        <table class="table-auto w-full"> {{-- full width --}}
            <thead>
                <tr>
                    <th class="px-4 py-2"> {{-- padding x of 4 --}}
                        <div class="flex items-center">ID</div>
                    </th>
                    <th class="px-4 py-2"> {{-- padding x of 4 --}}
                        <div class="flex items-center">Name</div>
                    </th>
                    <th class="px-4 py-2"> {{-- padding x of 4 --}}
                        <div class="flex items-center">Price</div>
                    </th>
                    <th class="px-4 py-2"> {{-- padding x of 4 --}}
                        <div class="flex items-center">Stock</div>
                    </th>
                    <th class="px-4 py-2"> {{-- padding x of 4 --}}
                        Category
                    </th>
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
                        <td class="border px-4 py-2">{{$product->categorie->name}}</td>
                        <td class="border px-4 py-2">Edit | Delete</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{$products->links()}} {{-- we use pagination to show data in different pages --}}
    </div>
</div>
