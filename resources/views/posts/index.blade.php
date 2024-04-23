<x-app-layout :meta-title="'THe Blog - By Category ' . $category->title" :meta-description="'Blogs By Category'">
  <!-- Posts Section -->
  <section class="w-full md:w-2/3 flex flex-col items-center px-3">

   @foreach ($posts as $post)
       <x-post-item :post="$post"></x-post-item>
   @endforeach

   <!-- Pagination -->
   {{$posts->onEachSide(1)->links()}}
   
 </section>

  <x-side-bar></x-side-bar>
</x-app-layout>