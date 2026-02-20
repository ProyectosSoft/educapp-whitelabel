        <div class="max-w-7xl mx-auto  px-4 sm:px-6 lg:px-8 py-8 grid grid-cols-5 gap-6">
            <div class="col-span-3">
                <div class="bg-white rounded-lg shadow p-6">
                    <h1>Información Personal</h1>
                    <div class="mb-4">
                        <x-label value="Nombre de Contacto" />
                        <x-input type="text" wire:model.defer="contact" placeholder="ingrese su nombre completo"
                            class="w-full" />
                    </div>
                    <div>
                        <x-label value="Telefono de Contacto" />
                        <x-input type="text" wire:model.defer="phone" placeholder="ingrese su Teléfono"
                            class="w-full" />

                        @error('phone')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 mt-4">
                    <h1>Código de Descuento o Referido</h1>
                    <div>
                        <!-- Input para ingresar el valor a restar -->
                        <div class="mb-4">
                            <x-label value="Valor a Restar" />
                            <x-input type="text" wire:model.defer="discountValue"
                                placeholder="Ingrese el valor a restar" class="w-full" />
                        </div>
                        <!-- Botón para aplicar el descuento -->
                        <x-button class="mb-4" wire:click="applyDiscount">
                            Aplicar Descuento
                        </x-button>
                    </div>
                    <div>
                        <br>
                        @if ($successMessage)
                            <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
                                role="alert">
                                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                </svg>
                                <span class="sr-only">Info</span>
                                <div>
                                    {{-- <span class="font-medium">Alerta de éxito!</span> --}}
                                    {{ $successMessage }}
                                </div>
                            </div>
                        @endif

                        @if ($errorMessage)
                            <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                                role="alert">
                                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                </svg>
                                <span class="sr-only">Info</span>
                                <div>
                                    {{-- <span class="font-medium">alerta de información!</span>  --}}
                                    {{ $errorMessage }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div>
                    {{-- <x-button class="mt-6 mb-4" wire.loading.attr="disabled" wire:target="create_order" --}}
                    <x-button class="mt-6 mb-4" wire.loading.attr="disabled" wire:target="create"
                        wire:click="create_order">
                        Continuar con la compra
                    </x-button>

                    <hr>
                    <p class="text-sm text-gray-800 mt-2"> Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                        Temporibus
                        libero vero doloribus iusto quidem officiis qui laboriosam, voluptatem nam distinctio pariatur
                        animi
                        autem error nesciunt nostrum consequuntur, dolor dolorem nulla.</p>
                </div>
            </div>
            <div class="col-span-2">
                <div class="bg-white rounded-lg shadow p-6">
                    <ul>
                        @forelse ($carlist as $item)
                            <li class="flex p-2 border-b border-gray-200">
                                {{-- <img class="h-16 w-20 object-cover mr-4" src="{{ $item->options->image }}" alt=""> --}}
                                <article class="flex-1">
                                    <h1 class="font-bold"> {{ $item->nombre }} </h1>
                                    <p>Cant: {{ 1 }} </p>
                                    <p>COP $ {{ number_format($item->price, 0, ',', '.') }} </p>
                                </article>
                            </li>
                        @empty
                            <li>
                                <p class="text-center text-greenLime_400 py-6 px-4">
                                    No tiene ningún curso agregado en el carrito
                                <p>
                            </li>
                        @endforelse
                    </ul>
                    <hr class="mt-4 mb-3">
                    <div class="text-gray-700">
                        <p class="flex justify-between items-center">
                            Subtotal
                            <span class="font-semibold">COP $
                                {{ number_format($carlist->sum('total'), 0, ',', '.') }}</span>
                        </p>
                        <p class="flex justify-between items-center">
                            Descuento
                            {{-- <span class="font-semibold">COP $ {{ number_format( $descuento, 0, ',', '.') }}</span> --}}
                            <span class="font-semibold">COP $
                                {{ number_format($carlist->sum('descuento'), 0, ',', '.') }}</span>
                        </p>
                        <p class="flex justify-between items-center">
                            Saldo a favor
                            <span class="font-semibold">COP $ {{ number_format($totalSaldo, 0, ',', '.') }}</span>
                        </p>
                        <hr class="mt-4 mb-3">
                        <p class="flex justify-between items-center font-semibold">
                            <span class="text-lg"> Total </span>
                            {{-- <span class="font-semibold">COP $ {{ number_format( $carlist->sum('total'), 0, ',', '.') }}</span> --}}
                            <span class="font-semibold">COP $ {{ number_format($total, 0, ',', '.') }}</span>
                        </p>
                    </div>
                </div>

            </div>
        </div>

        <script>
            function applyDiscount() {
                const cuponCode = document.getElementById('cuponCodeInput').value;
                @this.applyDiscount(cuponCode);
            }

            Livewire.on('discountUpdated', (total, subtotal, saldoAplicado) => {
                document.getElementById('subtotalInput').innerText = subtotal.toLocaleString('es-CO', {
                    style: 'currency',
                    currency: 'COP'
                });
                document.getElementById('discountInput').innerText = descuento.toLocaleString('es-CO', {
                    style: 'currency',
                    currency: 'COP'
                });
                document.getElementById('totalInput').innerText = total.toLocaleString('es-CO', {
                    style: 'currency',
                    currency: 'COP'
                });
            })
        </script>
