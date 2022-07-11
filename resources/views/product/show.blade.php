<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product') }}
        </h2>
    </x-slot>

    <div class="py-12"
         x-data="{
            'auctionRates': {{ json_encode($product->auctionRates) }},
            'auctionUsers': [],
            'collDownTime': collDown(new Date('{{ $product->auctionTime->left_time }}'))
         }"
         x-init="
            collDownTime.init();
            Echo.join('{{ 'auction-' . $product->id }}')
                .here(users => {
                    auctionUsers = users;
                })
                .joining((user) => {
                    auctionUsers.push(user)
                })
                .leaving((user) => {
                    auctionUsers = auctionUsers.filter(function(value, index, arr){
                        return value.name !== user.name;
                    });
                })
                .listen('AuctionRateUpEvent', (e) => {
                    auctionRates.unshift(e.auctionRate);
               })
               .listen('AuctionLeftTimeEvent', (e) => {
                    collDownTime.expiry = new Date(e.auctionTime.left_time)
                    collDownTime.init();
               })
            "
    >
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex gap-4" >
                <div class="w-1/2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            {{ $product->title }}
                        </div>
                        <div class="p-6">
                            <span>Price: </span>{{ $product->price }} UAH
                        </div>
                        <div class="p-6" x-show="collDownTime.remaining > 0">
                            <span>Left time: </span>
                            <span x-text="collDownTime.time().days"></span>:
                            <span x-text="collDownTime.time().hours"></span>:
                            <span x-text="collDownTime.time().minutes"></span>:
                            <span x-text="collDownTime.time().seconds"></span>
                        </div>
                        <div class="p-6"  x-show="collDownTime.remaining < 0">
                            <div>Left time: finished</div>
                        </div>
                    </div>
                </div>
                <div class="w-1/4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            Auction Rates
                        </div>
                        <div class="p-6">
                            <template x-if="auctionRates.length > 0">
                                <template
                                    x-for="auctionRate in auctionRates.slice(0, 5)"
                                    :key="auctionRate.id"
                                >
                                    <div class="">
                                        <div class="flex flex-row justify-between border-b border-gray-200">
                                            <span class="text-gray-600" x-text="auctionRate.user.name"></span>
                                            <span class="text-gray-800 text-sm font-semibold" x-text="auctionRate.price + ' UAH'"></span>
                                        </div>
                                        <div class="my-4 text-gray-800 text-xs" x-text="(new Date(auctionRate.created_at)).toLocaleString('en-US')"></div>
                                    </div>
                                </template>
                            </template>

                            <template x-if="auctionRates.length == 0">
                                <div class="py-4 text-gray-600">
                                    It's quiet in here...
                                </div>
                            </template>
                            <div class="">
                                <div
                                    class="flex gap-4"
                                    x-data="{
                                        price: 0,
                                        auctionRate:{}
                                    }"
                                >
                                    <input type="text" name="price" x-model="price" class="w-full"/>
                                    <button type="button"
                                            x-on:click="auctionRate = await (await axios.post('{{ route('products.action-rate.up', $product) }}', {'price' : price})).data; auctionRates.unshift(auctionRate);"
                                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
                                    >send</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-1/4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            Users
                        </div>
                        <div class="p-6">
                            <template x-if="auctionUsers.length > 0">
                                <template
                                    x-for="auctionUser in auctionUsers"
                                    :key="auctionUser.id"
                                >
                                    <div class="">
                                        <div class="flex flex-row justify-between border-b border-gray-200">
                                            <span class="text-gray-600" x-text="auctionUser.name"></span>
                                            <span class="text-gray-500 text-xs" x-text="auctionUser.email"></span>
                                        </div>
                                    </div>
                                </template>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
