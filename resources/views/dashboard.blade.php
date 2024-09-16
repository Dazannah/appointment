<x-app-layout>
  <x-slot:pageTitle>{{ $pageTitle ?? 'Page Title'}}</x-slot>
  <div class="max-w-screen mx-auto px-4 md:px-8">

    <div class="items-start justify-between md:flex p-2">
        <div class="max-w-lg">
            <h3 class="text-gray-800 dark:text-gray-400 dark:bg-gray-900 text-xl font-bold sm:text-2xl">All reservation</h3>
        </div>
        <div class="mt-3 md:mt-0">
            <a href="calendar" class="flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-gray-300 dark:hover:bg-gray-800 border dark:text-white dark:bg-gray-900">Make reservation</a>
        </div>
    </div>
    <div class="mt-12 relative h-max w-max overflow-auto">
              @if (count($reservations) > 0)
              <div>
                <div class="rounded-sm border border-stroke border-black bg-white px-5 pb-2.5 pt-6 shadow-default dark:bg-gray-800 dark:border-gray-800 dark:text-white sm:px-7.5 xl:pb-1">
                  <div class="flex flex-col">
                    <div class="grid grid-cols-3 rounded-sm bg-gray-2 dark:bg-meta-4 sm:grid-cols-6">
                      <div class="p-2.5 xl:p-5">
                        <h5 class="text-sm font-medium uppercase xsm:text-base">Title</h5>
                      </div>
                      <div class="p-2.5 text-center xl:p-5">
                        <h5 class="text-sm font-medium uppercase xsm:text-base">Status</h5>
                      </div>
                      <div class="p-2.5 text-center xl:p-5">
                        <h5 class="text-sm font-medium uppercase xsm:text-base">Price</h5>
                      </div>
                      <div class="p-2.5 text-center xl:p-5">
                        <h5 class="text-sm font-medium uppercase xsm:text-base">Start</h5>
                      </div>
                      <div class="hidden p-2.5 text-center sm:block xl:p-5">
                        <h5 class="text-sm font-medium uppercase xsm:text-base">End</h5>
                      </div>
                      <div class="hidden p-2.5 text-center sm:block xl:p-5">
                        <h5 class="text-sm font-medium uppercase xsm:text-base">Reserved at</h5>
                      </div>
                    </div>
        
                  @foreach ($reservations as $latestAppointment)
                    <a href="/event/{{$latestAppointment->id}}?from={{Request::path()}}">
                      <div class="grid grid-cols-3 border-b border-black hover:bg-gray-300 dark:hover:bg-gray-900 dark:border-strokedark dark:border-white sm:grid-cols-6">
                        <div class="flex items-center gap-3 p-2.5 xl:p-5">
                          <p class="hidden font-medium text-black dark:text-white sm:block">{{$latestAppointment->title}}</p>
                        </div>
                        <div class="flex items-center justify-center p-2.5 xl:p-5">
                          <p class="font-medium text-black dark:text-white">{{$latestAppointment->status->name}}</p>
                        </div>
                        <div class="flex items-center justify-center p-2.5 xl:p-5">
                          <p class="font-medium text-black dark:text-white">{{$latestAppointment->workType->price->price}} HUF</p>
                        </div>
                        <div class="flex items-center justify-center p-2.5 xl:p-5">
                          <p class="font-medium text-black dark:text-white">{{$latestAppointment->start}}</p>
                        </div>
                        <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                          <p class="font-medium text-black dark:text-white">{{$latestAppointment->end}}</p>
                        </div>
                        <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                          <p class="font-medium text-black dark:text-white">{{$latestAppointment->created_at}}</p>
                        </div>
                      </div>
                    </a>
                  @endforeach
        
                  </div>
                </div>
              </div>
              <div class="p-2">
                {{$reservations->links()}}
              </div>
              @else
              There is no previous reservations.
              @endif

    </div>
</div>
</x-app-layout>
