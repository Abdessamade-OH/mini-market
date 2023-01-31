
<div id="page-content" class="page-content">
    <div class="banner">
        <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('assets/img/bg-header.jpg');">
            <div class="container">
                <h1 class="pt-5">
                    Shopping Page
                </h1>
                <p class="lead">
                    Save time and leave the groceries to us.
                </p>
            </div>
        </div>
    </div>
    <div class="flex justify-between mt-6">
        <div>
            <input wire:model.debounce.200ms="q" type="search" placeholder="search" class=" mb-4 mt-4 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
        </div>
        <div class="mr-2"> {{-- margin --}}
            <label for="category">Category
                <select class="mr-6 leading-tight" id="category" wire:model="choosen">
                        <option value="all" default>All</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{$cat->name}}</option>
                    @endforeach
                </select>
            </label>
        </div>
    </div>
    
    

    {{-- @if($choosen === 'all')
        <div id="vegetables" >
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="title">All categories</h2>
                        @foreach($products as $product)
                            <div class="product-carousel owl-carousel">
                                <div class="item">
                                    <div class="card card-product">
                                        <div class="card-badge">
                                            <img src="{{ asset('assets/img/meats.jpg') }}" alt="Card image 2" class="card-img-top">
                                        </div>
                                        <div class="card-body">
                                            <h4 class="card-title">
                                                <a href="/product/detail">Product Title</a>
                                            </h4>
                                            <div class="card-price">
                                                <span class="reguler">Rp. 200.000</span>
                                            </div>
                                            <a href="/product/detail" class="btn btn-block btn-primary">
                                                Add to Cart
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <h1>test</h1>
    @else
        <div class="container">
                <div class="col-md-12">
                    <h2 class="title"><i class="{{$selected->icon_class}}"></i>  {{$selected->name}}</h2>
                </div>
                <div class="flex flex-row flex-wrap">
                    @foreach($products as $product)
                        <div class="card rounded-none">
                            {{$product->name}}
                        </div>
                    @endforeach
                </div>
        </div>
    @endif --}}


    <table class="table-auto w-full "> {{-- full width --}}
        <thead>
            <tr>
                <th class="px-4 py-2"> {{-- padding x of 4 --}}
                    <div class="flex items-center">
                        ID
                    </div>
                </th>
                <th class="px-4 py-2"> {{-- padding x of 4 --}}
                    <div class="flex items-center">
                        Name
                    </div>
                </th>
                <th class="px-4 py-2"> {{-- padding x of 4 --}}
                    <div class="flex items-center">
                        Price
                    </div>
                </th>
                <th class="px-4 py-2"> {{-- padding x of 4 --}}
                    <div class="flex items-center">
                        Stock
                    </div>
                </th>
                @if($choosen === 'all')
                    <th class="px-4 py-2"> {{-- padding x of 4 --}}
                        Category
                    </th>
                @endif
                <th class="px-4 py-2"> {{-- padding x of 4 --}}
                    <div class="flex items-center">
                        Buy
                    </div>
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
                    @if($choosen === 'all')
                        <td class="border px-4 py-2">{{$product->categorie->name}}</td>
                    @endif
                    <td class="border px-4 py-2">
                        <div class="flex justify-center">
                            {{-- stock --}}
                            <x-jet-label for="quantity" class="mt-2 mr-2" value="{{ __('Quantity') }}" />
                            <x-jet-input id="quantity" type="number" min="1" class="mr-6 block" wire:model.defer="quantity" />
                            <x-jet-input-error for="quantity"/>

                            <x-jet-button wire:click="confirmProductBuy({{$product->id}})" class="mr-6 bg-blue-500 hover:bg-blue-700">
                                Add To Cart
                            </x-jet-button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


</div>