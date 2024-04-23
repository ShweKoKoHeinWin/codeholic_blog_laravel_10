<x-app-layout :meta-title="'The Blog - About Us'" :meta-description="'This is about us page of the blog'">
  <!-- Posts Section -->
  <section class="w-full flex flex-col items-center px-3">

    <article class="flex flex-col shadow my-4">
      <!-- Article Image -->
      <a href="" class="hover:opacity-75">
          <img src="{{$about->image}}">
      </a>
      <div class="bg-white flex flex-col justify-start p-6">
        
         <a href="" class="text-blue-700 text-sm font-bold uppercase pb-4">{{$about->title}}</a>
       
          <a href="" class="pb-6">
              {!! $about->content !!}
          </a>
      
      </div>
    </article>

 </section>
</x-app-layout>