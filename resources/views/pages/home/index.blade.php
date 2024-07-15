<x-kfbr>
    <!-- Blog 4 - Bootstrap Brain Component -->
    <section class="py-3 py-md-5 py-xl-8">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-10 col-lg-8">
                    <h3 class="fs-5 mb-2 text-secondary text-uppercase">Blog</h3>
                    <h2 class="display-5 mb-4">Here is our blog's latest company news about regularly publishing fresh
                        content.</h2>
                    <button type="button" class="btn btn-lg btn-primary mb-3 mb-md-4 mb-xl-5">All Blog Posts</button>
                </div>
            </div>
        </div>

        <div class="container overflow-hidden">
            <div class="row gy-4 gy-lg-0">
                @forelse ($posts as $post)
                    <!-- component -->
                    <!-- This is an example component -->
                    <div class="max-w-lg mx-auto">
                        <div class="bg-white shadow-md border border-gray-200 rounded-lg max-w-sm mb-5">
                            <a href="#">
                                <img class="rounded-t-lg" src="{{$post->thumbnail}}"
                                    alt="">
                            </a>
                            <div class="p-5">
                                <a href="#">
                                    <h5 class="text-gray-900 font-bold text-2xl tracking-tight mb-2">{{$post->title}}</h5>
                                </a>
                                <p class="font-normal text-gray-700 mb-3">{{$post->slug}}</p>
                                <a class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 text-center inline-flex items-center"
                                    href="{{route('post', ['id'=>$post->id])}}">
                                    Read more
                                </a>
                            </div>
                        </div>

                    </div>
                @empty
                    <h2 class="text-center">No posts found</h2>
                @endforelse
            </div>

        </div>
    </section>
    <div class="container text-center">{{ $posts->links() }}</div>
</x-kfbr>
