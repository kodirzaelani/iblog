<div>
    @livewire('template.frontend.terasblue.partials.hero')
    {{-- @livewire('template.frontend.terasblue.partials.slider') --}}

    <main>
        <section class="bg-section pt-5">
            <div class="container-fluid mt-3 mb-5">
                <div class="row">
                    <div class="col-md-8">
                        @livewire('template.frontend.terasblue.post.fposthome')
                    </div>
                    <div class="col-md-4">
                        @livewire('template.frontend.terasblue.partials.sidebarhome')
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
