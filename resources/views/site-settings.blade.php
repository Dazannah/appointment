<x-app-layout>
    <x-slot:pageTitle>{{ $pageTitle ?? 'Page Title'}}</x-slot>
    <div class="mx-auto max-w-screen-2xl md:p-6 2xl:p-10 grid grid-cols-2">
        <!-- ====== Settings Section Start -->
        <div class="grid mx-auto grid-cols-5 gap-8">
          <div class="col-span-5 xl:col-span-5">
            <div class="rounded-sm border border-stroke border-black bg-white shadow-default dark:bg-gray-800 dark:border-gray-800 dark:text-white">
              <div class="p-7">
                <form action="/admin/site-settings" method="post">
                  @csrf
                  <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                    <div class="p-2 w-full sm:w-1/2">
                      <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="workdayStart">Workday Start</label>
                      <div class="relative">
                        <input value="{{old('workdayStart') ?? $configs['calendarTimes']['slotMinTime']}}" type="time" name="workdayStart" id="workdayStart" placeholder="Workday Start" class="border-black w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-medium text-black focus:border-primary focus-visible:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        @error('workdayStart')
                            {{$message}}
                        @enderror
                    </div>
                    </div>
                    <div class="p-2 w-full sm:w-1/2">
                      <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="workdayEnd">Workday End</label>
                          <div class="relative">
                              <input value="{{old('workdayEnd') ?? $configs['calendarTimes']['slotMaxTime']}}" type="time" name="workdayEnd" id="workdayEnd" placeholder="Workday End" class="border-black w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-medium text-black focus:border-primary focus-visible:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                @error('workdayEnd')
                                    {{$message}}
                                @enderror
                            </div>
                    </div>
                  </div>
                  <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                    <div class="p-2 w-full">
                      <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="workdayEnd">Closed days name</label>
                          <div class="relative">
                              <input value="{{old('closedDaysTitle') ?? $configs['closedDays']['title']}}" text="time" name="closedDaysTitle" id="closedDaysTitle" placeholder="Closed days name" class="border-black w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-medium text-black focus:border-primary focus-visible:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                @error('closedDaysTitle')
                                    {{$message}}
                                @enderror
                          </div>
                    </div>
                  </div>


                  {{--<div class="p-2 mb-5.5">
                      <div>
                          <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Price
                          </label>
                          <div class="relative z-20 bg-white dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <select name="price" class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 pl-5 pr-12 outline-none transition focus:border-primary active:border-primary dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                              <option value="">Select</option>
                              @foreach ($prices as $price)
                                  <option value="{{$price->id}}">{{$price->price}}</option>
                              @endforeach
                              
                            </select>
                          </div>
                        </div>
                  </div>--}}


                    <div class="flex justify-end py-2">
                        <button class="border-black flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-green-500 dark:hover:text-black dark:hover:bg-green-500 border dark:text-white dark:bg-gray-900" type="submit">
                            Save
                        </button>
                    </div>
                </form>
              </div>
            </div>              
          </div>
        </div>

        <div class="grid mx-auto grid-cols-5 gap-8">
          <div class="col-span-5 xl:col-span-5">
            <div class="rounded-sm border border-stroke border-black bg-white shadow-default dark:bg-gray-800 dark:border-gray-800 dark:text-white">
              <div class="p-7">
                <form action="/admin/site-settings/fill-holidays" method="post">
                  @csrf
                  <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="year">Fill holidays on year</label>
                  <input type="number" min="2020" max="2100" step="1" name="year" value="{{date('Y')}}" class="border-black w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-medium text-black focus:border-primary focus-visible:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                  @error('year')
                    {{$message}}
                  @enderror
                  <div class="flex justify-end gap-4.5 py-2">
                    <button class="border-black flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-green-500 dark:hover:text-black dark:hover:bg-green-500 border dark:text-white dark:bg-gray-900" type="submit">
                        Start
                    </button>
                  </div>
                </form>
              </div>
            </div>              
          </div>
        </div>
        <!-- ====== Settings Section End -->
    </div>
</x-app-layout>