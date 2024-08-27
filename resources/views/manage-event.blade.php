<x-app-layout>
  <x-slot:pageTitle>{{ $pageTitle ?? 'Page Title'}}</x-slot>
  <div class="mx-auto max-w-screen-2xl md:p-6 2xl:p-10">
    <!-- ====== Settings Section Start -->
    <div class="grid mx-auto grid-cols-5 gap-8">
      <div class="col-span-5 xl:col-span-5">
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:bg-gray-800 dark:border-gray-800 dark:text-white">
          <div class="p-7">
            <form action="/event/{{$event->id}}" method="post">
              @method('patch')
              @csrf
              <h1 class="text-2xl">{{$event->title}} - {{$event->status->name}}</h1><br>
              <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                  <div class="p-2 w-full sm:w-1/2">
                      <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="createdAt">Created at</label>
                      <input class="w-full rounded border border-stroke bg-gray px-4.5 py-3 font-medium text-black focus:border-primary focus-visible:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="datetime-local" name="createdAt" id="createdAt" value="{{$event->created_at}}" disabled>
                    </div>

                  <div class="p-2 w-full sm:w-1/2">
                      <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="start">Start</label>
                      <input class="w-full rounded border border-stroke bg-gray px-4.5 py-3 font-medium text-black focus:border-primary focus-visible:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="datetime-local" name="start" id="start" value="{{$event->start}}" disabled>
                  </div>

                  <div class="p-2 w-full sm:w-1/2">
                      <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="end">End</label>
                      <input class="w-full rounded border border-stroke bg-gray px-4.5 py-3 font-medium text-black focus:border-primary focus-visible:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="datetime-local" name="end" id="end" value="{{$event->end}}" disabled>
                  </div>
              </div>

              <div class="p-2 mb-5.5">
                <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="note">User note</label>
                <div class="relative">
                  <textarea class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-medium text-black focus:border-primary focus-visible:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="note" id="note" placeholder="User note">{{$event->note}}</textarea>
                </div>
              </div>

              <div class="p-2 mb-5.5">
              <div class="flex items-center h-5">
                <input id="delete" onchange="confirmDelete()" name="delete" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" />
                <label for="delete" class="ms-2 text-sm font-medium text-red-500 dark:text-red-600">Delete</label>
              </div>
            </div>
              <div class="flex justify-end gap-4.5">
                  <button class="flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-green-500 dark:hover:text-black dark:hover:bg-green-500 border dark:text-white dark:bg-gray-900" type="submit">
                      Save
                  </button>
                  <button onclick="goToDashboard()" class="flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-red-500 dark:hover:text-black dark:hover:bg-red-500 border dark:text-white dark:bg-gray-900">
                      Cancel
                  </button>
              </div>
            </form>
          </div>
        </div>              
      </div>
    </div>
    <!-- ====== Settings Section End -->
</div>

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