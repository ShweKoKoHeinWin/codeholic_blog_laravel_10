<x-app-layout meta-description="THis is meta description.">
   <!-- Posts Section -->
   <section class="w-full flex flex-col items-center px-3">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div class="col-span-2">
        {{-- Latest Posts --}}
        <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase pb-1 border-b-2 border-blue-500 mb-3">
          Latest Posts
        </h2>
        <x-post-item :post="$latestPosts"></x-post-item>
      </div>

      <div class="">
        {{-- Popular Posts --}}
        <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase pb-1 border-b-2 border-blue-500 mb-3">
          Popular Posts
        </h2>
        @foreach ($popularPosts as $post)
          <div class="grid grid-cols-4 gap-2 mb-3">
            <a href="{{route('view', $post)}}" class="pt-3">
              <img src="{{$post->getThumbnail()}}" alt="{{$post->title}}" class="aspect-[4/3] object-contain">
            </a>
            <div class="col-span-3">
              <a href="{{route('view', $post)}}">
                <h2 class="font-semibold uppercase whitespace-nowrap text-ellipsis overflow-hidden">{{$post->title}}</h2>
              </a>
              @foreach ($post->categories as $category)
              <a href="{{route('by-category', $category)}}" class="bg-blue-500 text-white rounded p-1 text-xs font-bold uppercase">{{$category->title}}</a>
              @endforeach
              <p class="text-sm">{{$post->shortBody(10)}}</p>
              <a href="{{route('view', $post)}}" class="text-xs uppercase text-gray-800 hover:text-black">Continue Reading <i class="fas fa-arrow-right"></i></a>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <div>
      {{-- Recommended Posts --}}
      <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase pb-1 border-b-2 border-blue-500 mb-3">
        Recommended Posts
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-3">
        @foreach ($recomendedPosts as $post)
        <x-post-item :post="$post" :show-author="false"></x-post-item>
        @endforeach
      </div>
    </div>

    <div>
      {{-- Latest Categories --}}
      <h2 class="text-lg sm:text-xl text-center font-bold text-blue-500 uppercase pb-1 border-b-2 border-blue-500 mb-3">
        Latest Categories
      </h2>
      @foreach ($categories as $category)
          <h3 class="text-center font-semibold">
            {{$category->title}}
          </h3>
          <div class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                @foreach($category->publishedPosts()->limit(3)->get() as $post)
                    <x-post-item :post="$post" :show-author="false"/>
                @endforeach
            </div>
        </div>
      @endforeach
    </div>
    {{-- @foreach ($posts as $post)
        <x-post-item :post="$post"></x-post-item>
    @endforeach --}}

    {{-- <!-- Pagination -->
    {{$posts->onEachSide(1)->links()}} --}}
    
    </section>
</x-app-layout>