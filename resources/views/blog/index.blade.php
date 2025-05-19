<x-app>
    <!-- blog-area-start -->
    <section class="blog-area pt-30">
        <div class="container-fluid">
            <x-blog.carousel :posts="$carposts" />
        </div>
    </section>
    <!-- blog-area-end -->

    <!-- blog-area-start -->
    <section class="blog-area pt-80">
        <div class="container">
            <livewire:blog-index :kategori-slug="$kategoriSlug ?? null" :tag-slug="$tagSlug ?? null" />
        </div>
    </section>
    <!-- blog-area-end -->
</x-app>