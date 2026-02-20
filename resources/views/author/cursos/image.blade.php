<x-app-layout>
  <img src="{{"data:image/image;base64," . base64_encode(Storage::get($course->image->url));}}" />
</x-app-layout>
