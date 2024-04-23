<x-app-layout :meta-title="$post->meta_title ?: $post->title" :meta-description="$post->description">
  <!-- Posts Section -->
  <section class="w-full md:w-2/3 flex flex-col items-center px-3">

    <x-post-item :post="$post"></x-post-item>

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