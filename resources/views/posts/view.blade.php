<x-app-layout :meta-title="$post->meta_title ?: $post->title" :meta-description="$post->description">
  <!-- Posts Section -->
  <section class="w-full md:w-2/3 flex flex-col items-center px-3">

    <article class="flex flex-col shadow my-4">
      <!-- Article Image -->
      <a href="{{route('view', $post)}}" class="hover:opacity-75">
          <img src="{{$post->getThumbnail()}}">
      </a>
      <div class="bg-white flex flex-col justify-start p-6">
         @foreach ($post->categories as $category)
         <a href="" class="text-blue-700 text-sm font-bold uppercase pb-4">{{$category->title}}</a>
         @endforeach
          <a href="{{route('view', $post)}}" class="text-3xl font-bold hover:text-gray-700 pb-4">{{$post->title}}</a>
          <p href="#" class="text-sm pb-3">
              By <a href="#" class="font-semibold hover:text-gray-800">{{$post->user->name}}</a>, Published on {{$post->getFormattedDate()}}
          </p>
          <a href="{{route('view', $post)}}" class="pb-6">
              {{$post->body}}
          </a>
          <livewire:upvotedownvote :post="$post"/>
          <a href="{{route('view', $post)}}" class="uppercase text-gray-800 hover:text-black">Continue Reading <i class="fas fa-arrow-right"></i></a>
      </div>
    </article>

 </section>

 <div class="w-full flex pt-6">
  @if ($previous)
  <a href="{{route('view', $previous)}}" class="w1/2 bg-white shadow hover:shadow-md text-left p-6">
    <p class="text-lg text-blue-800 font-bold flex items-center">
      <i class="fas fa-arrow-left pr-1"></i>
      Pevious
    </p>
    <p class="pt-2">
      {{\Illuminate\Support\Str::words($previous->title, 10)}}
    </p>
  </a>
  @endif
 
  @if ($next)
  <a href="{{route('view', $next)}}" class="w1/2 bg-white shadow hover:shadow-md text-left p-6">
    <p class="text-lg text-blue-800 font-bold flex items-center">
      <i class="fas fa-arrow-right pr-1"></i>
      Next
    </p>
    <p class="pt-2">
      {{\Illuminate\Support\Str::words($next->title)}}
    </p>
  </a>
  @endif
 </div>




  <x-side-bar></x-side-bar>
</x-app-layout>