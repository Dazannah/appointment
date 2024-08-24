<x-app-layout>
  <x-slot:pageTitle>{{ $pageTitle ?? 'Page Title'}}</x-slot>
  <form class="max-w-sm mx-auto" action="/event/{{$event->id}}" method="post">
    @method('patch')
    @csrf
    <h1 class="text-2xl">{{$event->title}} - {{$event->status->name}}</h1><br>
    <div class="mb-5">
      <label for="start-date" class="block mb-2 text-sm font-medium dark:text-gray-400 dark:bg-gray-900">Start time</label>
      <input value="{{$event->start}}" type="datetime-local" id="start-date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Start time" required readonly/>
    </div>
    <div class="mb-5">
      <label for="end-date" class="block mb-2 text-sm font-medium dark:text-gray-400 dark:bg-gray-900">End time</label>
      <input value="{{$event->end}}" type="datetime-local" id="end-date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required readonly/>
    </div>
    <div class="mb-5">
      <textarea class="block mb-2 text-sm font-medium dark:text-gray-400 dark:bg-gray-900" id="note" name="note" cols="30" rows="10" placeholder="Note can be write here">{{$event->note}}</textarea>
    </div>
    <div class="flex items-start mb-5">
      <div class="flex items-center h-5">
        <input id="delete" onchange="confirmDelete()" name="delete" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" />
      </div>
      <label for="delete" class="ms-2 text-sm font-medium text-red-500 dark:text-red-600">Delete</label>
    </div>
    <button type="submit" class="py-1.5 px-3 text-gray-600 hover:bg-gray-300 dark:hover:bg-gray-800 hover:bg-gray-50 border rounded-lg dark:text-white dark:bg-gray-900">Submit</button>
  </form>

  <script>
    function confirmDelete() {
      const checkBox = document.getElementById('delete')

      if(checkBox.checked){
        if(!confirm("If the appointment within 24H you agre to pay a penalty fee of 10.000 HUF Are you sure?")){
          checkBox.checked = false
        }
      }
      
    }
  </script>
</x-app-layout>