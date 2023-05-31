<div class="" x-data="eventCarousel()">

    <div class="flex py-4 overflow-x-auto sg-flex-gap snap-x snap-mandatory no-scrollbar snap-padding-gutter"
            x-ref="slider"
            x-on:scroll.debounce.250ms="updateDots()"
            >

        <div class="flex-shrink-0 w-gutter-gap snap-start"></div>

            @foreach( $events as $event )

                <div class="flex-shrink-0 w-[70vw] md:w-con-1/3 snap-start">

                    <div class="flex flex-wrap justify-center">

                        <img src="/img/window-4@2x.png" class="w-[150px] lg:w-[250px]" alt="">

                        <div class="text-center w-full py-4 flex justify-center">

                            <div class="leading-6 ">

                                <div class="w-36 lg:w-40 lg:mx-auto">

                                    <p class="lg:text-2xl">
                                        {{ $event->name }}
                                    </p>

                                </div>

                                <p class="lg:text-xl">
                                    with {{ $event->sub_title }}
                                </p>

                                <p class="">
                                    {{ '£' . number_format( $event->price, 2 )  }}
                                </p>

                            </div>

                        </div>

                        <a href="{{ $event->booking_url }}" class="pt-btn pt-btn-cream text-base">
                            book now
                            <i class="fa fa-arrow-right-long ml-2"></i>
                        </a>

                    </div>

                </div>

            @endforeach

    </div>

    <div class="absolute z-20 flex justify-center w-full bottom-6 md:hidden">

        @for( $i = 1; $i <= $events->count(); $i++ )

            <div class="w-1.5 h-1.5 rounded-full mx-1 cursor-pointer"
                    x-on:click="scrollTo( {{ $i }} )"
                    x-bind:class="dotIndex == {{ $i }} ? 'bg-white' : 'bg-purple-900'"></div>

        @endfor

    </div>

</div>

<script>
    function eventCarousel() {
        return {
            scrollPercent: 0,
            dotIndex: 1,
            slideCount: 10,
            updateDots() {
                this.$data.scrollPercent = this.$refs.slider.scrollLeft / this.$refs.slider.scrollWidth;
                this.$data.dotIndex = Math.round(this.$data.scrollPercent * this.$data.slideCount) + 1;
            },
            scrollTo(index) {
                this.$refs.slider.scrollTo({ left: ((index - 1) / this.slideCount) * this.$refs.slider.scrollWidth, behavior: 'smooth' });
            }
        }
    }
</script>