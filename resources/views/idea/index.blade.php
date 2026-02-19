<x-layout>
    <div>



        <header class="py-8 md:py-12">
            <p class="text-3xl font-bold">Ideas</p>
            <p class="text-muted-foreground text-sm mt-2">Capture your thoughts. Make a plan. </p>

            <x-card
                data-test="create-idea-button"
                x-data
                @click="$dispatch('open-modal', 'create-idea')"
                is="button"
                type="button"
                class="mt-10 cursor-pointer h-32 w-full text-left"
            >
                <p>What's the Idea?</p>
            </x-card>
        </header>

        <div>
            <a href="/ideas" class="rounded-md btn {{ !request('status') || request('status') === 'all' ? '' : 'btn-outlined' }}">
                All ({{ $statusCounts->get('all') }})
            </a>
            @foreach(\App\IdeaStatus::cases() as $status)
                <a
                    href="/ideas?status={{ $status->value  }}" class="rounded-md btn {{ request('status') === $status->value ? '' : 'btn-outlined' }}"
                >
                    {{ $status->label() }} <span class="text-xs pl-1">
                        ({{ $statusCounts->get($status->value) }})
                    </span>
                </a>
            @endforeach
        </div>

        <div class="mt-10 text-muted-foreground">
            <div class="grid md:grid-cols-2 gap-6">

                @forelse($ideas as $idea)
                    <x-card href="{{ route('idea.show', $idea) }}">
                        <h3 class="text-foreground text-lg">{{ $idea->title }}</h3>
                        <div class="mt-2">
                            <x-idea.status-label status="{{ $idea->status }}">
                                {{ $idea->status->label() }}
                            </x-idea.status-label>
                        </div>
                        <div class="mt-5 line-clamp-3">{{ $idea->description }}</div>
                        <div class="mt-4">{{ $idea->created_at->diffForHumans() }}</div>
                    </x-card>
                @empty
                    <x-card>
                        <p>No Ideas at this time.</p>
                    </x-card>
                @endforelse

            </div>
        </div>


        <!-- Create Idea Modal -->
        <x-modal name="create-idea" title="Create New Idea">
            <form
                x-data="{
                    status: 'pending',
                    newLink: '',
                    links: [],
                }"
                action="{{ route('idea.store') }}"
                method="POST">
                @csrf

                <div class="space-y-6">
                    <x-form.field
                        label="Title"
                        name="title"
                        placeholder="Enter a title for your idea"
                        autofocus
                        required
                    />

                    <div class="space-y-2">
                        <label for="status" class="label">Status</label>

                        <div class="flex gap-x-3">
                            @foreach(App\IdeaStatus::cases() as $status)
                                <button
                                    data-test="button-status-{{ $status->value }}"
                                    type="button"
                                    @click="status = @js($status->value)"
                                    class="btn flex-1 h-10"
                                    :class="status === @js($status->value) ? '' : 'btn-outlined'">
                                    {{ $status->label() }}
                                </button>
                            @endforeach

                            <input type="hidden" name="status" :value="status">
                        </div>

                        <x-form.error name="status" />

                    </div>

                    <x-form.field
                        label="Description"
                        name="description"
                        type="textarea"
                        placeholder="Describe your idea..."
                    />

                    <div>
                        <fieldset class="space-y-3">

                            <legend class="label">Links</legend>

                            <template x-for="(link, index) in links">
                                <div class="flex items-center gap-x-2">
                                    <input name="links[]" x-model="link" class="input">

                                    <button
                                        @click="links.splice(index, 1)"
                                        type="button"
                                        class="text-md font-bold hover:text-red-800 focus:outline-none text-red-800/80">
                                        <span class="text-md font-bold">x</span>
                                    </button>


                                </div>
                            </template>

                            <div class="flex gap-x-2 items-center">

                                <input
                                    x-model="newLink"
                                    type="url"
                                    id="new-link"
                                    placeholder="https://example.com"
                                    autocomplete="url"
                                    class="input flex-1 h-11"
                                    spellcheck="false"
                                >

                                <button
                                    @click="links.push(newLink.trim()); newLink= '';"
                                    type="button"
                                    class="h-11 w-11 flex items-center justify-center"
                                    :disabled="!newLink">
                                    <span class="text-4xl leading-none">+</span>
                                </button>

                            </div>



                        </fieldset>
                    </div>


                    <div class="flex justify-end gap-x-5">
                        <button @click="$dispatch('close-modal')" type="button">Cancel</button>
                        <button type="submit" class="btn">Create</button>
                    </div>

                </div>




            </form>
        </x-modal>

    </div>
</x-layout>
