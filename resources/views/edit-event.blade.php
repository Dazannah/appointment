<x-app-layout>
    <x-slot:pageTitle>{{ $pageTitle ?? 'Page Title'}}</x-slot>
    <div class="mx-auto max-w-screen-2xl md:p-6 2xl:p-10">
          <!-- ====== Settings Section Start -->
          <div class="grid mx-auto grid-cols-5 gap-8">
            <div class="col-span-5 xl:col-span-5">
              <div class="rounded-sm border border-stroke bg-white shadow-default dark:bg-gray-800 dark:border-gray-800 dark:text-white">
                <div class="p-7">
                  <form action="/admin/event/{{$event->id}}" method="post">
                    @method('patch')
                    @csrf
                    <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                      <div class="p-2 w-full sm:w-1/2">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="workType">Work type</label>
                        <div class="relative">
                          <input class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-medium text-black focus:border-primary focus-visible:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="workType" id="workType" placeholder="Name" value="{{$event->workType->name}}" disabled>
                        </div>
                      </div>
                      <div class="p-2 w-full sm:w-1/2">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="fullName">User name</label>
                        <div class="relative">
                          <input class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-medium text-black focus:border-primary focus-visible:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="fullName" id="fullName" placeholder="Name" value="{{$event->user->name}}" disabled>
                        </div>
                      </div>
                    </div>

                    <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                        <div class="p-2 w-full sm:w-1/2">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="createdAt">Created at</label>
                            <input class="w-full rounded border border-stroke bg-gray px-4.5 py-3 font-medium text-black focus:border-primary focus-visible:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="datetime-local" name="createdAt" id="createdAt" value="{{$event->created_at}}" disabled>
                          </div>

                        <div class="p-2 w-full sm:w-1/2">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="start">Start</label>
                            <input class="w-full rounded border border-stroke bg-gray px-4.5 py-3 font-medium text-black focus:border-primary focus-visible:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="datetime-local" name="start" id="start" value="{{$event->start}}" disabled>
                        </div>

                        <div class="p-2 w-full sm:w-1/2">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="end">End</label>
                            <input class="w-full rounded border border-stroke bg-gray px-4.5 py-3 font-medium text-black focus:border-primary focus-visible:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="datetime-local" name="end" id="end" value="{{$event->end}}" disabled>
                        </div>
                    </div>

                    <div class="p-2 mb-5.5">
                      <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="userNote">User note</label>
                      <div class="relative">
                        <textarea class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-medium text-black focus:border-primary focus-visible:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="userNote" id="note" placeholder="User note">{{$event->note}}</textarea>
                      </div>
                    </div>

                    <div class="p-2 mb-5.5">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="adminNote">Admin note</label>
                        <div class="relative">
                          <textarea class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-medium text-black focus:border-primary focus-visible:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="adminNote" id="adminNote" placeholder="Admin note">{{$event->note}}</textarea>
                        </div>
                      </div>

                    <div class="p-2 mb-5.5">
                        <div>
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                              Status
                            </label>
                            <div class="relative z-20 bg-white dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                              <select name="status" class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 pl-5 pr-12 outline-none transition focus:border-primary active:border-primary dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="{{$event->status?->id}}">{{$event->status?->name}}</option>
                                @foreach ($statuses as $status)
                                  @if ($status->id != $event->status->id)
                                    <option value="{{$status->id}}">{{$status->name}}</option>
                                  @endif
                                @endforeach
                                
                              </select>
                            </div>
                          </div>
                    </div>

                    {{--<div class="p-2 mb-5.5">
                        <input type="checkbox" name="isEmailVerified" id="isEmailVerified" {{isset($user->email_verified_at) ? "checked" : ""}} @disabled(true)>
                        <label class="text-sm font-medium" for="isEmailVerified">Email verified</label><br>
                        <input type="checkbox" name="isAdmin" id="isAdmin" {{$event->is_admin ? "checked" : ""}}>
                        <label class="text-sm font-medium" for="isAdmin">Admin</label>
                    </div>--}}

                    <div class="flex justify-end gap-4.5">
                        <button class="flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-green-500 dark:hover:text-black dark:hover:bg-green-500 border dark:text-white dark:bg-gray-900" type="submit">
                            Save
                        </button>
                        <button onclick="goBack()" class="flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-red-500 dark:hover:text-black dark:hover:bg-red-500 border dark:text-white dark:bg-gray-900">
                            Back
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