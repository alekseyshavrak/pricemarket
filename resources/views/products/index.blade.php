@php
/** @var \Illuminate\Pagination\LengthAwarePaginator|\App\Domain\Product\Product[] $products */
@endphp

<x-app-layout title="Products">
    <div class="flex items-start justify-between space-x-5">
        <div class="w-64">
            <!-- Filter -->
            <div class="bg-gray-100 p-5 mb-20">
                <form action="{{ route('home') }}" class="space-y-10">
                    <div class="space-y-1">
                        <x-label for="fieldCity">@lang('Город')</x-label>
                        <x-select
                            id="fieldCity"
                            multiple
                            name="cities[]"
                            :items="data_get($attributes, 'city')"
                            :selected="request('cities')"
                        />
                    </div>
                    <div class="space-y-1">
                        <x-label for="fieldCategory">@lang('Категория')</x-label>
                        <x-select
                            id="fieldCategory"
                            name="category"
                            :items="data_get($attributes, 'category')"
                            :selected="request('category')"
                        />
                    </div>
                    <x-button class="w-full justify-center">
                        @lang('Показать')
                    </x-button>
                </form>
            </div>
        </div>
        <div class="flex-1">
            <!-- Items -->
            <div class="grid grid-cols-3 gap-12">
                @foreach($products as $product)
                    <x-product
                        :title="$product->name"
                        :price="format_money($product->getItemPrice()->pricePerItemIncludingVat())"
                        :actionUrl="action(\App\Http\Controllers\Cart\AddCartItemController::class, [$product])"
                    />
                @endforeach
            </div>

            <!-- Pagination -->
            @if($products->hasMorePages())
                <div class="mx-auto mt-12">
                    {{ $products->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>

</x-app-layout>
