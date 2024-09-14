<x-app-layout>
    <x-slot:pageTitle>{{ $pageTitle ?? 'Page Title'}}</x-slot>
    <div class="mx-auto max-w-screen-2xl md:p-6 2xl:p-10">
          <!-- ====== Settings Section Start -->
          <div class="mx-auto gap-8">
              <div class="rounded-sm border border-stroke bg-white shadow-default dark:bg-gray-800 dark:border-gray-800 dark:text-white">
                  <form class="grid grid-cols-2 gap-8 p-2" action="/admin/closed-days/create" method="post">
                    @csrf
                        <div class="grid-cols-1 p-2 mb-5.5">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="price">Start date</label>
                            <input onchange="setEndDateToSameIfEmpty(this)" type="date" name="startDate" id="startDate" value="{{old('startDate')}}" class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-medium text-black focus:border-primary focus-visible:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            @error('startDate')
                                {{$message}}
                            @enderror
                        </div>
                        <div class="grid-cols-1 p-2 mb-5.5">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="price">End date</label>
                            <input type="date" name="endDate" id="endDate" value="{{old('endDate')}}" class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-medium text-black focus:border-primary focus-visible:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            @error('endDate')
                                {{$message}}
                            @enderror
                        </div>

                    <div class="flex justify-end gap-4.5">
                        <button id="submitButton" class="flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-green-500 dark:hover:text-black dark:hover:bg-green-500 border dark:text-white dark:bg-gray-900" type="submit">
                            Save
                        </button>
                        <a href="{{ request()->has('from') ? request()->get('from') . '?' : '/admin/menu/closed-days' }}" class="flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-red-500 dark:hover:text-black dark:hover:bg-red-500 border dark:text-white dark:bg-gray-900">
                            Back
                        </a>
                    </div>
                  </form>
            </div>
          </div>
      </div>
  </x-app-layout>