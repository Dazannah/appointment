<x-app-layout>
  <div class="max-w-screen-xl mx-auto px-4 md:px-8">

    <div class="items-start justify-between md:flex">
        <div class="max-w-lg">
            <h3 class="text-gray-800 dark:text-gray-400 dark:bg-gray-900 text-xl font-bold sm:text-2xl">All reservation</h3>
        </div>
        <div class="mt-3 md:mt-0">
            <a href="make-reservation" class="inline-block px-4 py-2 border text-gray-600 dark:text-white font-medium rounded-lg hover:bg-gray-300 dark:hover:bg-gray-800 md:text-sm">Make reservation</a>
        </div>
    </div>
    <div class="mt-12 relative h-max overflow-auto">
              @if (count($reservations) > 1)
              <table class="w-full table-auto text-sm text-left">
                <thead class="text-gray-600 dark:text-gray-400 dark:bg-gray-900 font-medium border-b">
                    <tr>
                        <th class="py-3 pr-6">Title</th>
                        <th class="py-3 pr-6">Start</th>
                        <th class="py-3 pr-6">End</th>
                        <th class="py-3 pr-6">Reserved at</th>
                        <th class="py-3 pr-6"></th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 divide-y">

                @foreach ($reservations as $reservation)
                  <tr>
                    <td class="pr-6 py-4 whitespace-nowrap dark:text-gray-400 dark:bg-gray-900">{{$reservation->title}}</td>
                    <td class="pr-6 py-4 whitespace-nowrap dark:text-gray-400 dark:bg-gray-900">{{$reservation->start}}</td>
                    <td class="pr-6 py-4 whitespace-nowrap dark:text-gray-400 dark:bg-gray-900">{{$reservation->end}}</td>
                    <td class="pr-6 py-4 whitespace-nowrap dark:text-gray-400 dark:bg-gray-900">{{$reservation->created_at}}</td>
                    <td class="text-right whitespace-nowrap dark:text-gray-400 dark:bg-gray-900">
                        <a href="/event/{{$reservation->id}}" class="py-1.5 px-3 text-gray-600 hover:bg-gray-300 dark:hover:bg-gray-800 hover:bg-gray-50 border rounded-lg dark:text-white dark:bg-gray-900">Manage</a>
                    </td>
                  </tr>
                @endforeach
  
                </tbody>
              </table>
              @else
              There is no previous reservations.
              @endif

    </div>
</div>
</x-app-layout>