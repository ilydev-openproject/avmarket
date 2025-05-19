<div class="postbox__comment mb-65">
    <h3 class="postbox__comment-title mb-35">Komentar</h3>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Daftar Komentar -->
    <ul>
        @forelse($comments as $comment)
            <li>
                <div class="postbox__comment-box d-flex">
                    <div class="postbox__comment-info">
                        <div class="postbox__comment-avater mr-25">
                            <img src="{{ asset('assets/img/blog/comment-' . ($loop->index % 3 + 1) . '.jpg') }}" alt="">
                        </div>
                    </div>
                    <div class="postbox__comment-text">
                        <div class="postbox__comment-name">
                            <h5>{{ $comment->user ? $comment->user->name : 'Pengguna Tidak Dikenal' }}</h5>
                            <span>{{ $comment->created_at->format('M d, Y') }}</span>
                        </div>
                        <p>{{ $comment->content }}</p>
                        <div class="postbox__comment-reply">
                            <a href="#" wire:click.prevent="setReplyTo({{ $comment->id }})">Balas</a>
                        </div>
                    </div>
                </div>
                @if($comment->replies->count())
                    <ul class="children mb-30">
                        @foreach($comment->replies as $reply)
                            <li>
                                <div class="postbox__comment-box pl-90 d-flex">
                                    <div class="postbox__comment-info">
                                        <div class="postbox__comment-avater mr-25">
                                            <img src="{{ asset('assets/img/blog/comment-' . ($loop->index % 3 + 1) . '.jpg') }}"
                                                alt="">
                                        </div>
                                    </div>
                                    <div class="postbox__comment-text">
                                        <div class="postbox__comment-name">
                                            <h5>{{ $reply->user ? $reply->user->name : 'Pengguna Tidak Dikenal' }}</h5>
                                            <span>{{ $reply->created_at->format('M d, Y') }}</span>
                                        </div>
                                        <p>{{ $reply->content }}</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @empty
            <li>Belum ada komentar.</li>
        @endforelse
    </ul>

    <!-- Form Reply (jika sedang membalas komentar) -->
    @auth
        @if($replyTo)
            <div class="tpreview__form postbox__form mt-30">
                <h4 class="tpreview__form-title mb-10">Balas Komentar</h4>
                <form wire:submit.prevent="submitReply">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tpreview__input mb-5">
                                <textarea name="text" placeholder="Balasan Anda" wire:model="replyContent"></textarea>
                                @error('replyContent') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="tpfooter__widget-newsletter-check postbox__check-box">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" wire:model="saveInfo" id="saveReplyInfo">
                                    <label class="form-check-label" for="saveReplyInfo">
                                        Simpan informasi saya untuk nanti.
                                    </label>
                                </div>
                            </div>
                            <div class="tpreview__submit mt-25">
                                <button type="submit" class="tp-btn">Kirim Balasan</button>
                                <button type="button" class="tp-btn btn-secondary" wire:click="cancelReply">Batal</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        @endif

        <!-- Form Komentar Baru -->
        <div class="tpreview__form postbox__form mt-30">
            <h4 class="tpreview__form-title mb-10">Tulis Komentar</h4>
            <p>Data Anda akan dienkripsi dengan aman.</p>
            <form wire:submit.prevent="submitComment">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tpreview__input mb-5">
                            <textarea name="text" placeholder="Komentar Anda" wire:model="content"></textarea>
                            @error('content') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="tpfooter__widget-newsletter-check postbox__check-box">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="saveInfo" id="saveInfo">
                                <label class="form-check-label" for="saveInfo">
                                    Simpan informasi saya untuk nanti.
                                </label>
                            </div>
                        </div>
                        <div class="tpreview__submit mt-25">
                            <button type="submit" class="tp-btn">Kirim Komentar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @else
        <div class="alert alert-info mt-30">
            <p>Silakan <a class="text-success-custom" href="{{ route('login') }}">login disini</a> untuk mengirim komentar.
            </p>
        </div>
    @endauth
</div>