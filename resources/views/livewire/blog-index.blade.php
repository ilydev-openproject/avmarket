@php
    use App\Models\Tags;
@endphp
<div class="row">
    <div class="col-xl-10 col-lg-9 mx-auto">
        <div class="tpblog__left-wrapper">
            <div class="tpblog__left-item">
                <!-- Posts -->
                <div class="row">
                    @forelse($posts as $post)
                        <div class="col-lg-6 col-md-6">
                            <div class="tpblog__item tpblog__item-2 mb-20">
                                <div class="tpblog__thumb fix">
                                    <a href="{{ route('blog.show', $post->slug) }}">
                                        @if($post->getFirstMedia('post_image'))
                                            <picture>
                                                @if($post->getFirstMedia('post_image')->hasGeneratedConversion('avif'))
                                                    <source srcset="{{ $post->getFirstMedia('post_image')->getUrl('avif') }}"
                                                        type="image/avif">
                                                @endif
                                                <source srcset="{{ $post->getFirstMedia('post_image')->getUrl('webp') }}"
                                                    type="image/webp">
                                                <img src="{{ $post->getFirstMediaUrl('post_image') }}" alt="{{ $post->title }}"
                                                    class="w-full h-48 object-cover overflow-hidden">
                                            </picture>
                                        @else
                                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-500">Tidak ada gambar</span>
                                            </div>
                                        @endif
                                    </a>
                                </div>
                                <div class="tpblog__wrapper">
                                    <div class="tpblog__entry-wap">
                                        <span class="cat-links"><a
                                                href="{{ route('blog.index', ['kategori' => $post->kategori_id]) }}">{{ $post->kategori->nama_kategori }}</a></span>
                                        <span class="author-by"><a href="#">Admin</a></span>
                                        <span class="post-data"><a
                                                href="#">{{ $post->created_at->translatedFormat('d F Y') }}</a></span>
                                    </div>
                                    <h4 class="tpblog__title"><a
                                            href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h4>
                                    <p>{{ Str::limit(strip_tags($post->content), 150) }}</p>
                                    <div class="tpblog__details">
                                        <a href="{{ route('blog.show', $post->slug) }}">Lanjut baca <i
                                                class="icon-chevrons-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-center text-gray-500">Tidak ada posting ditemukan.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            @if($posts->total() > 0 && $posts->lastPage() > 1)
                <div class="tpbasic__pagination pr-100">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="basic-pagination text-center mb-80">
                                <nav>
                                    <ul class="flex justify-center space-x-2">
                                        @if($posts->onFirstPage())
                                            <li><span class="current d-none"></span></li>
                                        @else
                                            <li><a href="{{ $posts->previousPageUrl() }}"><i class="icon-chevrons-left"></i></a>
                                            </li>
                                        @endif
                                        @foreach($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                                            <li>
                                                @if($page == $posts->currentPage())
                                                    <span class="current">{{ $page }}</span>
                                                @else
                                                    <a href="{{ $url }}">{{ $page }}</a>
                                                @endif
                                            </li>
                                        @endforeach
                                        @if($posts->hasMorePages())
                                            <li><a href="{{ $posts->nextPageUrl() }}"><i class="icon-chevrons-right"></i></a>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="col-xl-2 col-lg-3">
        <div class="tpblog__right-item pb-50">
            <!-- Search -->
            <div class="sidebar__widget mb-30">
                <div class="sidebar__widget-content">
                    <div class="sidebar__search">
                        <form>
                            <div class="sidebar__search p-relative">
                                <input type="text" placeholder="Search" wire:model.live="search">
                                <button type="submit"><i class="far fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Categories -->
            <div class="sidebar__widget mb-40">
                <h3 class="sidebar__widget-title mb-15">Blog Categories</h3>
                <div class="sidebar__widget-content">
                    <ul>
                        @foreach($kategoris as $kategori)
                            <li>
                                <a href="{{ route('blog.byKategori', $kategori['slug']) }}">

                                    {{ ucwords($kategori['nama']) }} ({{ $kategori['count'] }})
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Recent Posts -->
            <div class="sidebar__widget mb-35">
                <h3 class="sidebar__widget-title mb-15">Recent Posts</h3>
                <div class="sidebar__widget-content">
                    <div class="sidebar__post rc__post">
                        @foreach($recentPosts as $post)
                            <div class="rc__post mb-20 d-flex align-items-center">
                                <div class="rc__post-thumb">
                                    <a href="{{ route('blog.show', $post->slug) }}">
                                        @if($post->getFirstMedia('post_image'))
                                            <picture>
                                                <source srcset="{{ $post->getFirstMedia('post_image')->getUrl('webp') }}"
                                                    type="image/webp">
                                                <img src="{{ $post->getFirstMediaUrl('post_image') }}" alt="{{ $post->title }}"
                                                    class="w-16 h-16 object-cover">
                                            </picture>
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-500">No image</span>
                                            </div>
                                        @endif
                                    </a>
                                </div>
                                <div class="rc__post-content">
                                    <h3 class="rc__post-title">
                                        <a
                                            href="{{ route('blog.show', $post->slug) }}">{{ Str::limit($post->title, 50) }}</a>
                                    </h3>
                                    <div class="rc__meta">
                                        <span>{{ $post->created_at->translatedFormat('d F Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Tags -->
            <div class="sidebar__widget mb-55">
                <h3 class="sidebar__widget-title mb-15">Tags</h3>
                <div class="sidebar__widget-content">
                    <div class="tagcloud">
                        @foreach($tags as $id => $nama)
                            @php
                                $slug = Tags::find($id)->slug;
                            @endphp
                            <a href="{{ route('blog.byTag', $slug) }}">
                                {{ ucwords($nama) }}
                            </a>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>