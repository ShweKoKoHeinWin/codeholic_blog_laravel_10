<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Comment;

class CommentItem extends Component
{
    public bool $editing = false;
    public bool $replying = false;
    protected $listeners = [
        'cancelEditing' => 'cancelEditing',
        'commentUpdated' => 'commentUpdated',
        'commentCreated' => 'commentCreated'
    ];
    public Comment $comment;
    public function mount(Comment $comment) {
        $this->comment = $comment;
    }
    public function render()
    {
        return view('livewire.comment-item');
    }
    public function deleteComment() {
        $user = auth()->user();
        if(!$user) {
            return $this->redirect('/login');
        }
        $id = $this->comment->id;
        if($this->comment->user_id !== $user->id) {
            return response('You are not allowed to perform this action', 403);
        }
        $this->comment->delete();
        $this->dispatch('commentDeleted', $id);
    }
    public function startCommentEdit() {
        $this->editing = true;
    }
    public function cancelEditing() {
        $this->editing = false;
        $this->replying = false;
    }
    public function commentUpdated() {
        $this->editing = false;
    }
    public function startReply() {
        $this->replying = true;
    }
    public function commentCreated() {
        $this->replying = false;
    }
}
