<x-app-layout>
    <x-slot:pageTitle>{{ $pageTitle ?? 'Page Title'}}</x-slot>
    @guest
    <div class="grid grid-cols-3 gap-3 m-auto mt-5">
    @endguest
    @auth
    <div class="grid grid-cols-4 gap-3 m-auto mt-5">
    @endauth
        <form class="col-span-3" action="/prices" method="GET">
            <div class="grid grid-cols-3 gap-1">
                    <div class="col-span-1">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Worktype
                        </label>
                        <input value="{{Request::get('name') ?? '' }}" name="name" type="text" placeholder="Worktype name" class="border-black dark:border-white w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">
                    </div>
                    <div class="col-span-1">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Duration
                        </label>
                        <input value="{{Request::get('duration') ?? '' }}" name="duration" type="number" placeholder="Duration" class="border-black dark:border-white w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">
                    </div>
                    <div class="col-span-1">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Price
                        </label>
                        <input value="{{Request::get('price') ?? '' }}" name="price" type="number" placeholder="Price" class="border-black dark:border-white w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">
                    </div>

                    <div class="grid grid-cols-2 w-max justify-items-center items-center">
                        <div class="col-span-1">
                            <input type="submit" value="Submit" class="border-black dark:border-white hover:cursor-pointer flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-green-500 dark:hover:bg-green-500 hover:dark:text-black border dark:text-white dark:bg-gray-900">
                        </div>
                        <div class="col-span-1">
                            <a href="/prices" class="border-black dark:border-gray-300 hover:cursor-pointer flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-red-500 dark:hover:bg-red-500 hover:dark:text-black border dark:text-white dark:bg-gray-900">Reset</a>
                        </div>
                    </div>
            </div>
        </form>
        @if (count($worktypes) > 0)
          @guest
            <div class="col-span-3">
          @endguest
          @auth
            <div class="col-span-4">
          @endauth
                <div class="border-black dark:border-white grid grid-cols-1 p-3 gap-3 h-fit py-3 rounded-sm border border-stroke bg-white pb-2.5 pt-6 shadow-default dark:bg-gray-800 dark:border-gray-800 dark:text-white sm:px-7.5 xl:pb-1">
                    @foreach ($worktypes as $worktype)
                    @guest
                    <span class="grid-cols-3 px-7.5 py-3 p-2 border-b border-black hover:bg-gray-300 dark:border-white hover:bg-gray-300 dark:hover:bg-gray-900">
                      <div class="grid grid-cols-3 justify-items-center items-center border-stroke hover:bg-gray-300 hover:bg-gray-300 dark:hover:bg-gray-900 dark:border-strokedark">
                    @endguest
                    @auth
                    <span class="grid-cols-4 px-7.5 py-3 p-2 border-b border-black hover:bg-gray-300 dark:border-white hover:bg-gray-300 dark:hover:bg-gray-900">
                      <div class="grid grid-cols-4 justify-items-center items-center border-stroke hover:bg-gray-300 hover:bg-gray-300 dark:hover:bg-gray-900 dark:border-strokedark">
                    @endauth
                            <div class="col-span-1">
                                <span>{{$worktype->name}}</span>
                            </div>
                            <div class="col-span-1">
                                <span>{{$worktype->duration}} mins</span>
                            </div>
                            <div class="col-span-1">
                                <span>{{$worktype->price->price}} HUF</span>
                            </div>
                            @auth
                              <button id="{{$worktype->id}}" name="{{$worktype->name}}" onclick="recommendNextAvailable(this)" class="border-black hover:border-white col-span-1 rounded border border-stroke px-6 py-2 font-medium text-black bg-white hover:bg-gray-300 dark:hover:bg-gray-800 border dark:text-white dark:bg-gray-900">Reserve</button>
                            @endauth
                          </div>

                    </span>
                    @endforeach
                </div> 
                <div class="p-2">
                    {{$worktypes->links()}}
                </div>
            </div>
        @else
            <div class="col-span-4">
                <div class="grid grid-cols-1 gap-3 h-fit py-3 rounded-sm border border-stroke bg-white pb-2.5 pt-6 shadow-default dark:bg-gray-800 dark:border-gray-800 dark:text-white sm:px-7.5 xl:pb-1">
                    <span class="text-2xl justify-self-center self-center">No matching result.</span>
                </div>
            </div>
        @endif
    </div>

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
              <div id="options-div" class="max-w-sm mx-auto space-y-3 text-center">
                <form action="/make-reservation" method="post">
                  @csrf
                  <div class="mb-5">
                    <input id="worktype-title" class="mb-2 text-sm font-medium dark:text-gray-400 dark:bg-gray-900" id="title" name="title" readonly required>
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
                  <a href="/calendar" class="py-1.5 px-3 text-gray-600 hover:bg-gray-300 dark:hover:bg-gray-800 hover:bg-gray-50 border rounded-lg dark:text-white dark:bg-gray-900">Calendar</a>
                </form>
              </div>
              <div id="no-available-div" class="max-w-sm mx-auto space-y-3 text-center hidden">
              </div>
            </div>
          </div>
        </div>
      </div>
  </x-app-layout>