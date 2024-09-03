<x-app-layout>
    <x-slot:pageTitle>{{ $pageTitle ?? 'Page Title'}}</x-slot>
    <div class="mx-auto max-w-screen-2xl md:p-6 2xl:p-10">
          <!-- ====== Settings Section Start -->
          <div class="grid mx-auto grid-cols-5 gap-8">
            <div class="col-span-5 xl:col-span-5">
              <div class="rounded-sm border border-stroke bg-white shadow-default dark:bg-gray-800 dark:border-gray-800 dark:text-white">
                <div class="p-7">
                  <form action="/admin/worktype/create" method="post">
                    @csrf
                    <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                      <div class="p-2 w-full sm:w-1/2">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="worktypeName">Worktype</label>
                        <div class="relative">
                          <input value="{{ Request::get('worktypeName') ?? old('worktypeName') }}" class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-medium text-black focus:border-primary focus-visible:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="worktypeName" id="worktypeName" placeholder="Worktype Name" required>
                        </div>
                      </div>
                      <div class="p-2 w-full sm:w-1/2">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="duration">Duration(min)</label>
                            <div class="relative">
                                <input value="{{Request::get('duration') ?? old('duration') }}" class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-medium text-black focus:border-primary focus-visible:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="number" name="duration" id="duration" placeholder="Duration" required>
                            </div>
                      </div>
                    </div>


                    <div class="p-2 mb-5.5">
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
                    </div>


                    <div class="flex justify-end gap-4.5">
                        <button class="flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-green-500 dark:hover:text-black dark:hover:bg-green-500 border dark:text-white dark:bg-gray-900" type="submit">
                            Save
                        </button>
                        <a href="/admin/menu/worktypes" class="flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-red-500 dark:hover:text-black dark:hover:bg-red-500 border dark:text-white dark:bg-gray-900">
                            Back
                        </a>
                        <button onclick="redirectToCreatePrice(event, '/admin/price/create?from=/admin/worktype/create')" class="flex justify-self-start rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-green-500 dark:hover:text-black dark:hover:bg-green-500 border dark:text-white dark:bg-gray-900">Add new price</button>
                    </div>
                  </form>
                </div>
              </div>              
            </div>
          </div>
          <!-- ====== Settings Section End -->
      </div>
  </x-app-layout>