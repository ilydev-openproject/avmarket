<x-app>
    <!-- breadcrumb-area-start -->
    <div class="breadcrumb__area pt-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-breadcrumb__content">
                        <div class="tp-breadcrumb__list">
                            <span class="tp-breadcrumb__active"><a href="{{ route('blog.index') }}">Blog</a></span>
                            <span class="dvdr">/</span>
                            <span class="tp-breadcrumb__active"><a
                                    href="{{ route('blog.byKategori', $post->kategori->slug) }}">{{ $post->kategori->nama_kategori }}</a></span>
                            <span class="dvdr">/</span>
                            <span>{{ $post->title }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area-end -->

    <!-- blog-details-area-start -->
    <section class="blog-details-area pb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-blog-details__thumb">
                        @if($post->getFirstMedia('post_image'))
                            <picture>
                                <source srcset="{{ $post->getFirstMedia('post_image')->getUrl('webp') }}" type="image/webp">
                                <img src="{{ $post->getFirstMediaUrl('post_image') }}" alt="{{ $post->title }}">
                            </picture>
                        @else
                            <div class="w-16 h-16 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500">No image</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-10 col-lg-12">
                    <div class="tp-blog-details__wrapper">
                        <div class="tp-blog-details__content">
                            <div class="tpblog__entry-wap mb-5">
                                <span class="cat-links"><a
                                        href="{{ route('blog.byKategori', $post->kategori->slug) }}">{{ $post->kategori->nama_kategori }}</a></span>
                                <span class="author-by"><a href="#">Admin</a></span>
                                <span class="post-data"><a
                                        href="#">{{ $post->created_at->translatedFormat('d F Y') }}</a></span>
                            </div>
                            <h2 class="tp-blog-details__title mb-25">{{ $post->title }}</h2>
                            <p>{!! $post->content !!}</p>
                            <!-- Sisanya tetap sama, sesuaikan dengan data $post -->
                        </div>
                        <!-- Tambahan untuk tag -->
                        <div class="postbox__tag-border mb-45">
                            <div class="row align-items-center">
                                <div class="col-xl-7 col-lg-6 col-md-12">
                                    <div class="postbox__tag">
                                        <div class="postbox__tag-list tagcloud">
                                            <span>Tagged: </span>
                                            @foreach($post->tags as $tag)
                                                <a href="{{ route('blog.byTag', $tag->slug) }}">{{ $tag->nama_tag }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-5 col-lg-6 col-md-12">
                                    <div class="postbox__social-tag">
                                        <span>share:</span>
                                        <a class="blog-d-lnkd" href="#"><i class="fab fa-linkedin-in"></i></a>
                                        <a class="blog-d-pin" href="#"><i class="fab fa-pinterest-p"></i></a>
                                        <a class="blog-d-fb" href="#"><i class="fab fa-facebook-f"></i></a>
                                        <a class="blog-d-tweet" href="#"><i class="fab fa-twitter"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- navblog -->
                        <div class="tp-blog-details__post-link mb-15">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="tp-blog-details__post-item mb-30">
                                        @if($previousPost)
                                            <span><i class="far fa-chevron-left"></i> Sebelumnya</span>
                                            <div class="title d-flex justify-content-start">
                                                <div class="" style="max-width: 300px; text-wrap: wrap;">
                                                    <a
                                                        href="{{ route('blog.show', $previousPost->slug) }}">{{ $previousPost->title }}</a>
                                                </div>
                                            </div>
                                        @else
                                            <span class="d-none"><i class="far fa-chevron-left"></i> Previous Post</span>
                                            <a href="#" class="disabled d-none">No Previous Post</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 text-end">
                                    <div class="tp-blog-details__post-item text-end mb-30">
                                        @if($nextPost)
                                            <span>Berikutnya <i class="far fa-chevron-right"></i></span>

                                            <div class="title d-flex justify-content-end">
                                                <div class="" style="max-width: 300px; text-wrap: wrap;">
                                                    <a
                                                        href="{{ route('blog.show', $nextPost->slug) }}">{{ $nextPost->title }}</a>
                                                </div>
                                            </div>
                                        @else
                                            <span class="d-none">Next Post <i class="far fa-chevron-right"></i></span>
                                            <a href="#" class="disabled">No Next Post</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tp-blog-details__author d-flex  mb-45">
                            <div class="tp-blog-details__author-img mr-30">
                                <div class="wrp d-flex justify-content-center align-items-center"
                                    style="background-color: #001213; height: 70px; width: 70px; border-radius: 50%;">
                                    <span style="color: #fff;">A</span>
                                </div>
                            </div>
                            <div class="tp-blog-details__author-text">
                                <h3 class="tp-blog-details__author-title">Admin</h3>
                                <p>Ragam informasi menarik tentang permasalahan pasangan dewasa.</p>
                                <a href="#" class="author-btn">Semua Blog</a>
                            </div>
                        </div>
                        <!-- comment -->
                        <livewire:post-comments :post-id="$post->id" />
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app>