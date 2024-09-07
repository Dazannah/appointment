<x-app-layout>
    <x-slot:pageTitle>{{ $pageTitle ?? 'Page Title'}}</x-slot>
    <div class="grid grid-cols-3 gap-3 m-auto mt-5">
        <form class="col-span-3" action="/prices" method="GET">
            <div class="grid grid-cols-3 gap-1">
                    <div class="col-span-1">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Worktype
                        </label>
                        <input value="{{Request::get('name') ?? '' }}" name="name" type="text" placeholder="Worktype name" class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">
                    </div>
                    <div class="col-span-1">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Duration
                        </label>
                        <input value="{{Request::get('duration') ?? '' }}" name="duration" type="number" placeholder="Duration" class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">
                    </div>
                    <div class="col-span-1">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Price
                        </label>
                        <input value="{{Request::get('price') ?? '' }}" name="price" type="number" placeholder="Price" class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">
                    </div>

                    <div class="grid grid-cols-2 w-max justify-items-center items-center">
                        <div class="col-span-1">
                            <input type="submit" value="Submit" class="hover:cursor-pointer flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-green-500 dark:hover:bg-green-500 hover:dark:text-black border dark:text-white dark:bg-gray-900">
                        </div>
                        <div class="col-span-1">
                            <a href="/prices" class="hover:cursor-pointer flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-red-500 dark:hover:bg-red-500 hover:dark:text-black border dark:text-white dark:bg-gray-900">Reset</a>
                        </div>
                    </div>
            </div>
        </form>
        @if (count($worktypes) > 0)
            <div class="col-span-4">
                <div class="grid grid-cols-1 p-3 gap-3 h-fit py-3 rounded-sm border border-stroke bg-white pb-2.5 pt-6 shadow-default dark:bg-gray-800 dark:border-gray-800 dark:text-white sm:px-7.5 xl:pb-1">
                    @foreach ($worktypes as $worktype)
                    <span class="px-7.5 py-3 p-2 border-b border-black dark:border-white hover:bg-gray-300 dark:hover:bg-gray-900">
                        <div class="grid grid-cols-3 justify-items-center items-center border-stroke hover:bg-gray-300 dark:hover:bg-gray-900 dark:border-strokedark">
                            <div class="col-span-1">
                                <span>{{$worktype->name}}</span>
                            </div>
                            <div class="col-span-1">
                                <span>{{$worktype->duration}} mins</span>
                            </div>
                            <div class="col-span-1">
                                <span>{{$worktype->price->price}} HUF</span>
                            </div>
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
  </x-app-layout>