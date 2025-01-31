     <div class="py-4" x-data="{
        focused: {{$parentComment ? 'true' : 'false'}},
        isEdit : {{$commentModel ? 'true' : 'false'}}
        init() {
            if(this.isEdit || this.focused) {
                this.$refs.input.focus(); 
            }
            $wire.on('commentCreated', () => {
                this.focused = false;
                document.querySelector('#comment').value = '';
            })
        }
    }">
        <div>
            <textarea x-ref="input" wire:model='comment' id="comment" @click="focused = true" type="text" name="comment" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" :rows="isEdit || focused ? '6' : '1'"></textarea>
        </div>
        <div :class="isEdit || focused ? '' : 'hidden'">
            <button wire:click="createComment" type="submit" class=" rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
            <button @click="focused = false; isEdit = false; $wire.dispatch('cancelEditing')" class="px-4 py-2 bg-red-500 hover:bg-red-600 rounded text-white">Cancel</button>
        </div>
    </div>
