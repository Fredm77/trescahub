@if(isset($ctas) && $ctas->isNotEmpty())
    @foreach($ctas as $cta)
        <section class="cta-section py-16 bg-{{ $cta->bg_color ?? 'blue-600' }}">
            <div class="container mx-auto px-4 text-center">

                {{-- Category Badge --}}
                @if($cta->category)
                    <span class="inline-block mb-4 px-4 py-1 text-sm font-semibold rounded-full bg-white text-blue-600">
                        {{ $cta->category->title }}
                    </span>
                @endif

                {{-- Title --}}
                @if($cta->title)
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                        {{ $cta->title }}
                    </h2>
                @endif

                {{-- Description --}}
                @if($cta->description)
                    <p class="text-lg text-white/80 mb-8 max-w-2xl mx-auto">
                        {{ $cta->description }}
                    </p>
                @endif

                {{-- Buttons --}}
                <div class="flex flex-wrap justify-center gap-4">
                    @if($cta->primary_button_text && $cta->primary_button_url)
                        <a href="{{ $cta->primary_button_url }}"
                           class="px-8 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-gray-100 transition">
                            {{ $cta->primary_button_text }}
                        </a>
                    @endif

                    @if($cta->secondary_button_text && $cta->secondary_button_url)
                        <a href="{{ $cta->secondary_button_url }}"
                           class="px-8 py-3 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-blue-600 transition">
                            {{ $cta->secondary_button_text }}
                        </a>
                    @endif
                </div>

            </div>
        </section>
    @endforeach
@endif