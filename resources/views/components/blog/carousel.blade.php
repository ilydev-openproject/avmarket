<div class="swiper-container blog-active-3">
    <div class="swiper-wrapper">
        @foreach ($posts as $post)
            <div class="swiper-slide">
                <div class="tpblog__single p-relative">
                    <div class="tpblog__single-img">
                        @if($post->getFirstMedia('post_image'))
                            <picture>
                                @if($post->getFirstMedia('post_image')->hasGeneratedConversion('avif'))
                                    <source srcset="{{ $post->getFirstMedia('post_image')->getUrl('avif') }}" type="image/avif">
                                @endif
                                <source srcset="{{ $post->getFirstMedia('post_image')->getUrl('webp') }}" type="image/webp">
                                <img src="{{ $post->getFirstMediaUrl('post_image') }}" alt="{{ $post->title }}"
                                    class="post-image">
                            </picture>
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500">Tidak ada gambar</span>
                            </div>
                        @endif
                        <!-- <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}"> -->
                    </div>
                    <div class="tpblog__single-text text-center">
                        <div class="tpblog__entry-wap">
                            <span class="cat-links">
                                <a
                                    href="{{ url('blog/kategori/' . $post->kategori->slug) }}">{{ $post->kategori->nama_kategori }}</a>
                            </span>
                            <span class="author-by"><a href="#">Admin</a></span>
                            <span class="post-data">{{ $post->created_at->translatedFormat('d F Y') }}</span>
                        </div>
                        <h4 class="tpblog__single-title mb-20">
                            <a href="{{ url('blog/' . $post->slug) }}">{{ $post->title }}</a>
                        </h4>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>