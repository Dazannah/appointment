<x-app-layout>
  <x-slot:pageTitle>{{ $pageTitle ?? 'Page Title'}}</x-slot>
  {{-- https://tailadmin.com/ --}}
<main>
  <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5">

      @foreach ($weeksData as $weekData)
        <!-- Card Item Start -->
        <div class="rounded-sm p-2 border border-stroke bg-white px-7.5 py-6 shadow-default dark:bg-gray-800 dark:border-gray-800 dark:text-white">
          <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
            {{$weekData->title ?? "n/a"}}
          </div>
          <div class="mt-4 flex items-end justify-between">
            <div>
              <h4 class="text-title-md font-bold text-black dark:text-white">
                {{$weekData->pcs ?? "n/a"}} appointments
              </h4>
              <span class="text-sm font-medium">Reservation rate:</span>
            </div>

            <span class="flex items-center gap-1 text-sm font-medium text-meta-3">
              {{$weekData->percent ?? "n/a"}} %
            </span>
          </div>
        </div>
        <!-- Card Item End -->
      @endforeach
    </div>

    <div class="mt-4 grid grid-cols-12 gap-4 md:mt-6 md:gap-6 2xl:mt-7.5 2xl:gap-7.5">

      <!-- ====== Table One Start -->
      <div class="col-span-12 xl:col-span-8">
        <div class="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default dark:bg-gray-800 dark:border-gray-800 dark:text-white sm:px-7.5 xl:pb-1">
          <h4 class="mb-6 text-xl font-bold text-black dark:text-white">
            Latest 10 appointment
          </h4>
          <div class="flex flex-col">
            <div class="grid grid-cols-3 rounded-sm bg-gray-2 dark:bg-meta-4 sm:grid-cols-5">
              <div class="p-2.5 xl:p-5">
                <h5 class="text-sm font-medium uppercase xsm:text-base">Title</h5>
              </div>
              <div class="p-2.5 text-center xl:p-5">
                <h5 class="text-sm font-medium uppercase xsm:text-base">Status</h5>
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

          @foreach ($latestAppointments as $latestAppointment)
            <a href="/admin/event/{{$latestAppointment->id}}">
              <div class="grid grid-cols-3 border-b border-stroke hover:bg-gray-300 dark:hover:bg-gray-900 dark:border-strokedark sm:grid-cols-5">
                <div class="flex items-center gap-3 p-2.5 xl:p-5">
                  <div class="flex-shrink-0">
                  </div>
                  <p class="hidden font-medium text-black dark:text-white sm:block">{{$latestAppointment->title}}</p>
                </div>
                <div class="flex items-center justify-center p-2.5 xl:p-5">
                  <p class="font-medium text-black dark:text-white">{{$latestAppointment->status->name}}</p>
                </div>
                <div class="flex items-center justify-center p-2.5 xl:p-5">
                  <p class="font-medium text-meta-3">{{$latestAppointment->start}}</p>
                </div>
                <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                  <p class="font-medium text-black dark:text-white">{{$latestAppointment->end}}</p>
                </div>
                <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                  <p class="font-medium text-meta-5">{{$latestAppointment->created_at}}</p>
                </div>
              </div>
            </a>
          @endforeach

          </div>
        </div>
      </div>
      <!-- ====== Table One End -->

      <!-- ====== Chat Card Start -->
      <div class="col-span-12 rounded-sm border border-stroke bg-white py-6 shadow-default dark:bg-gray-800 dark:border-gray-800 dark:text-white xl:col-span-4">
        <h4 class="mb-6 px-2 text-xl font-bold text-black dark:text-white">Latest 10 registration</h4>
        <div>
          @foreach ($latest10Users as $user)
          <a href="/admin/user/{{$user->id}}" class="flex items-center gap-5 px-7.5 py-3 hover:bg-gray-300 dark:hover:bg-gray-900">
            <div class="flex flex-1 items-center justify-between">
              <div>
                <h5 class="px-2 font-medium text-black dark:text-white">
                  {{$user->name}}
                </h5>
                <p>
                  <span class="pl-2 text-sm font-medium text-black dark:text-white">Registration time</span>
                  <span class="text-xs">{{$user->created_at}}</span>
                  <span class="pl-2 text-sm font-medium text-black dark:text-white">Appointments:</span>
                  <span class="text-xs">{{count($user->event)}}</span>
                </p>
              </div>
            </div>
          </a>
          @endforeach
        </div>
      </div>
      <!-- ====== Chat Card End -->
    </div>
  </div>
</main>
<!-- ===== Main Content End ===== -->
</x-app-layout>