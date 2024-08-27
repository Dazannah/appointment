<x-app-layout>
    <x-slot:pageTitle>{{ $pageTitle ?? 'Page Title'}}</x-slot>
    <div class="mx-auto max-w-screen-2xl md:p-6 2xl:p-10">
        <div class="mx-auto max-w-270 p-4">
          <!-- ====== Settings Section Start -->
          <div class="grid grid-cols-8 gap-8">
            <div class="col-span-8 xl:col-span-8">
              <div class="rounded-sm border border-stroke bg-white shadow-default dark:bg-gray-800 dark:border-gray-800 dark:text-white">
                <div class="p-7">
                  <form action="/admin/user/{{$user->id}}" method="post">
                    @method('patch')
                    @csrf
                    <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                      <div class="p-2 w-full sm:w-1/2">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="fullName">Name</label>
                        <div class="relative">
                          <input class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-medium text-black focus:border-primary focus-visible:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="fullName" id="fullName" placeholder="Name" value="{{$user->name}}" required>
                        </div>
                      </div>

                      <div class="p-2 w-full sm:w-1/2">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="createdAt">Created at</label>
                        <input class="w-full rounded border border-stroke bg-gray px-4.5 py-3 font-medium text-black focus:border-primary focus-visible:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="datetime-local" name="createdAt" id="createdAt" value="{{$user->created_at}}" required>
                      </div>
                    </div>

                    <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                        <div class="p-2 w-full sm:w-1/2">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="updatedAt">Updated at</label>
                            <input class="w-full rounded border border-stroke bg-gray px-4.5 py-3 font-medium text-black focus:border-primary focus-visible:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="datetime-local" name="updatedAt" id="updatedAt" value="{{$user->updated_at}}" required>
                        </div>

                        <div class="p-2 w-full sm:w-1/2">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="updatedBy">Updated by</label>
                            <div class="relative">
                              <input class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-medium text-black focus:border-primary focus-visible:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="updatedBy" id="updatedBy" placeholder="Updated by" value="{{$user->updatedBy?->name}}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="p-2 mb-5.5">
                      <label class="mb-3 block text-sm font-medium text-black dark:text-white" for="emailAddress">Email Address</label>
                      <div class="relative">
                        <input class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-medium text-black focus:border-primary focus-visible:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="email" name="emailAddress" id="emailAddress" placeholder="E-mail" value="{{$user->email}}" required>
                      </div>
                    </div>

                    <div class="p-2 mb-5.5">
                        <div>
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                              Status
                            </label>
                            <div class="relative z-20 bg-white dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                              <select name="status" class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 pl-5 pr-12 outline-none transition focus:border-primary active:border-primary dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="{{$user->userStatus->id}}">{{$user->userStatus->name}}</option>
                                @foreach ($statuses as $status)
                                  @if ($status->id != $user->userStatus->id)
                                    <option value="{{$status->id}}">{{$status->name}}</option>
                                  @endif
                                @endforeach
                                
                              </select>
                            </div>
                          </div>
                    </div>

                    <div class="p-2 mb-5.5">
                        <input type="checkbox" name="isEmailVerified" id="isEmailVerified" {{isset($user->email_verified_at) ? "checked" : ""}} @disabled(true)>
                        <label class="text-sm font-medium" for="isEmailVerified">Email verified</label><br>
                        <input type="checkbox" name="isAdmin" id="isAdmin" {{$user->is_admin ? "checked" : ""}}>
                        <label class="text-sm font-medium" for="isAdmin">Admin</label>
                    </div>

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

                <div class="col-span-8 xl:col-span-8">
                    <div class="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default dark:bg-gray-800 dark:border-gray-800 dark:text-white sm:px-7.5 xl:pb-1">
                      <h4 class="mb-6 text-xl font-bold text-black dark:text-white">
                        Latest 10 appointments
                      </h4>
                      <a href="/admin/user/{{$user->id}}/all-apointments">
                      <button class="flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-gray-300 dark:hover:bg-gray-800 border dark:text-white dark:bg-gray-900" type="submit">
                        All appointments
                    </button>
                    </a>
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

          </div>
          <!-- ====== Settings Section End -->
        </div>
      </div>
  </x-app-layout>