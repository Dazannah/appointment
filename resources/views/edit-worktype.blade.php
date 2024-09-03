<x-app-layout>
    <x-slot:pageTitle>{{ $pageTitle ?? 'Page Title'}}</x-slot>
    <div class="mx-auto max-w-screen-2xl md:p-6 2xl:p-10">
          <!-- ====== Settings Section Start -->
          <div class="grid mx-auto grid-cols-5 gap-8">
            <div class="col-span-5 xl:col-span-5">
              <div class="rounded-sm border border-stroke bg-white shadow-default dark:bg-gray-800 dark:border-gray-800 dark:text-white">
                <div class="p-7">
                  <form action="/admin/worktype/{{$worktype->id}}" method="post">
                    @method('patch')
                    @csrf
                    <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                      <div class="p-2 w-full sm:w-1/2">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="worktypeName">Worktype</label>
                        <div class="relative">
                          <input class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-medium text-black focus:border-primary focus-visible:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="worktypeName" id="worktypeName" placeholder="Worktype Name" value="{{$worktype->name}}">
                        </div>
                      </div>
                      <div class="p-2 w-full sm:w-1/2">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="duration">Duration(min)</label>
                            <div class="relative">
                                <input class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-medium text-black focus:border-primary focus-visible:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="number" name="duration" id="duration" placeholder="Duration" value="{{$worktype->duration}}">
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
                                <option value="{{$worktype->price_id}}">{{$worktype->price->price}}</option>
                                @foreach ($prices as $price)
                                  @if ($price->id != $worktype->price_id)
                                    <option value="{{$price->id}}">{{$price->price}}</option>
                                  @endif
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
                        <a href="/admin/price/create?from=/admin/worktype/{{$worktype->id}}" class="flex justify-self-start rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-green-500 dark:hover:text-black dark:hover:bg-green-500 border dark:text-white dark:bg-gray-900">Add new price</a>
                    </div>
                  </form>
                  <form class="flex justify-end" action="/admin/worktype/delete/{{$worktype->id}}" method="post">
                    @method('delete')
                    @csrf
                    <input onclick="confirmWorktypeDelete(event)" type="submit" value="Delete" class="hover:cursor-pointer flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-red-500 dark:hover:text-black dark:hover:bg-red-500 border dark:text-white dark:bg-gray-900"/>
                  </form>
                </div>
              </div>              
            </div>
          </div>
          <!-- ====== Settings Section End -->
      </div>
  </x-app-layout>