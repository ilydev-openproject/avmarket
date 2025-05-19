<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostComments extends Component
{
    public $postId;
    public $content = '';
    public $saveInfo = false;
    public $replyTo = null;
    public $replyContent = '';

    protected $rules = [
        'content' => 'required|string',
        'replyContent' => 'required_if:replyTo,!=,null|string',
    ];

    public function mount($postId)
    {
        Log::info('PostComments mount called', ['postId' => $postId]);
        $this->postId = $postId;
        if (Auth::check() && session()->has('comment_info')) {
            $this->saveInfo = true;
        }
    }

    public function submitComment()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Silakan login untuk mengirim komentar.');
            return redirect()->route('login');
        }

        $this->validate(['content' => 'required|string']);

        Comment::create([
            'post_id' => $this->postId,
            'user_id' => Auth::id(),
            'content' => $this->content,
            'save_info' => $this->saveInfo,
        ]);

        if ($this->saveInfo) {
            session()->put('comment_info', ['user_id' => Auth::id()]);
        } else {
            session()->forget('comment_info');
        }

        $this->reset(['content', 'saveInfo']);
        session()->flash('message', 'Komentar berhasil dikirim!');
    }

    public function submitReply()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Silakan login untuk mengirim balasan.');
            return redirect()->route('login');
        }

        $this->validate(['replyContent' => 'required|string']);

        Comment::create([
            'post_id' => $this->postId,
            'user_id' => Auth::id(),
            'parent_id' => $this->replyTo,
            'content' => $this->replyContent,
            'save_info' => $this->saveInfo,
        ]);

        if ($this->saveInfo) {
            session()->put('comment_info', ['user_id' => Auth::id()]);
        }

        $this->reset(['replyContent', 'replyTo', 'saveInfo']);
        session()->flash('message', 'Balasan berhasil dikirim!');
    }

    public function setReplyTo($commentId)
    {
        if (!Auth::check()) {
            session()->flash('error', 'Silakan login untuk membalas komentar.');
            return redirect()->route('login');
        }
        $this->replyTo = $commentId;
    }

    public function cancelReply()
    {
        $this->reset(['replyTo', 'replyContent']);
    }

    public function render()
    {
        $comments = Comment::with(['replies', 'user'])
            ->where('post_id', $this->postId)
            ->whereNull('parent_id')
            ->latest()
            ->get();

        return view('livewire.post-comments', compact('comments'));
    }
}