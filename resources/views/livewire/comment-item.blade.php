<div>
    <div class="flex mb-3">
        <div class="w-12 h-12 flex items-center justify-center bg-gray-100 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
              </svg>
              
        </div>
        <div>
            <div>
                <a class="font-semibold text-indigo-800" href="">Jhn smith</a> - {{$comment->created_at->diffForHumans()}}
            </div>
            @if($editing)
            <livewire:comment-create :commentModel="$comment"/>
            @else
            <div>
                {{$comment->comment}}
            </div>
            @endif
            <div>
                <a wire:click.prevent="startReply" class="text-indigo-600" href="">Reply</a>
                @if(\Illuminate\Support\Facades\Auth::id() == $comment->user_id)
                <a wire:click.prevent="startCommentEdit" class="text-yellow-600" href="">Edit</a>
                <a wire:click.prevent="deleteComment" class="text-red-600" href="">Delete</a>
                @endif
            </div>
            @if($replying) 
            <livewire:comment-create :post="$comment->post" :parent-comment="$comment"/>
            @endif

            @if($comment->comments->count())
                @foreach($comment->comments as $childComment)
                    <livewire:comment-item :comment="$childComment" wire:key="comment-{{$comment->id}}-{{$childComment->id}}"/>
                @endforeach
            @endif
        </div>
        
    </div>
</div>
