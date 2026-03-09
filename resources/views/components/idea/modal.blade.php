@props(['idea' => new \App\Models\Idea()])


<!-- Create Idea Modal -->
<x-modal name="{{ $idea->exists  ? 'edit-idea' : 'create-idea' }}" title="{{ $idea->exists  ? 'Edit Idea' : 'Create New Idea' }}">
    <form
        x-data="{
                        status: @js(old('status', $idea->status->value)),
                        newLink: '',
                        links: [],
                        submit() {
                          // if the user typed a link but didn't press +
                          const v = this.newLink.trim();
                          if (v) {
                            this.links.push(v);
                            this.newLink = '';
                          }

                          // remove empties
                          this.links = this.links.map(l => l.trim()).filter(Boolean);

                          // wait for DOM inputs (x-for) to render, then submit
                          this.$nextTick(() => this.$el.submit());
                        }
                      }"
        @submit.prevent="submit()"
        action="{{ route('idea.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        <div class="space-y-6">
            <x-form.field
                label="Title"
                name="title"
                placeholder="Enter a title for your idea"
                autofocus
                required
                :value="$idea->title"
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
                :value="$idea->description"
            />

            <div class="space-y-2">
                <label for="image" class="label">Featured Image</label>

                @if($idea->image_path)
                    <div class="space-y-2">
                        <img src="{{ asset('storage/' . $idea->image_path) }}" alt="" class="w-full h-auto object-cover rounded-lg">
                        <button class="btn btn-outlined h-10 w-full" form="delete-image-form">Remove Image</button>
                    </div>
                @endif

                <input type="file" name="image" id="image" accept="image/*" />
            </div>

            <div>
                <fieldset class="space-y-3">

                    <legend class="label">Links</legend>

                    <template x-for="(link, index) in links" :key="index">
                        <div class="flex items-center gap-x-2">
                            <input name="links[]" x-model="links[index]" class="input">

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

    @if($idea->image_path)
        <form method="POST" action="{{ route('idea.image.destroy', $idea) }}" id="delete-image-form">
            @csrf
            @method('DELETE')
        </form>
    @endif

</x-modal>
