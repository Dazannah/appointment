<x-app-layout>
  <x-slot:pageTitle>{{ $pageTitle ?? 'Page Title'}}</x-slot>
  <div id='calendar' class="w-3/4 mx-auto"></div>
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>

  <div id="make-reserve-form" class="hidden fixed inset-0 z-10 overflow-y-auto">
    <div
      class="fixed inset-0 w-full h-full bg-black bg-opacity-40"
    >
      <div
        class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-lg mx-auto px-4"
      >
        <div class="text-gray-800 dark:text-gray-400 bg-white dark:bg-gray-900 rounded-md shadow-lg px-4 py-6">
          <div class="flex items-center justify-end">
            <button
              onclick="closeReserveFormDiv()"
              class="p-2 text-gray-400 rounded-md hover:bg-gray-100"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 mx-auto"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  fill-rule="evenodd"
                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                  clip-rule="evenodd"
                />
              </svg>
            </button>
          </div>
          <div id="options-div" class="max-w-sm mx-auto space-y-3 text-center hidden">
            <form action="/make-reservation" method="post">
              @csrf
              <div class="mb-5">
                <select class="mb-2 text-sm font-medium dark:text-gray-400 dark:bg-gray-900" onchange="setEndDate()" id="title" name="title" required>
                </select><br>
              </div>           
              <div class="mb-5">
                <label for="start-date" class="block mb-2 text-sm font-medium dark:text-gray-400 dark:bg-gray-900">Start time</label>
                <input type="datetime-local" name="start" id="start-date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Start time" required readonly/>
              </div>
              <div class="mb-5">
                <label for="end-date" class="block mb-2 text-sm font-medium dark:text-gray-400 dark:bg-gray-900">End time</label>
                <input type="datetime-local" name="end" id="end-date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required readonly/>
              </div>
              <div class="mb-5">
                <textarea class="mb-2 text-sm font-medium dark:text-gray-400 dark:bg-gray-900" id="note" name="note" cols="40" rows="10" placeholder="Note can be write here"></textarea>
              </div>
              <input id="workId" type="text" name="workId" readonly required hidden><br>
              <button type="submit" class="py-1.5 px-3 text-gray-600 hover:bg-gray-300 dark:hover:bg-gray-800 hover:bg-gray-50 border rounded-lg dark:text-white dark:bg-gray-900">Submit</button>
            </form>
          </div>
          <div id="no-available-div" class="max-w-sm mx-auto space-y-3 text-center hidden">
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>