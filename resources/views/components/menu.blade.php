
<div
                    class="flex items-center flex-shrink-0 h-16 px-8 border-b border-gray-300 dark:border-gray-800"
                >
                    <h1 class="text-lg font-medium">{{$pageTitle ?? 'Page Title'}}</h1>
                    @if (auth()->user()->admin)
                    <button
                        class="flex items-center justify-center h-10 px-4 ml-auto text-sm font-medium active:bg-gray-200 active:dark:bg-gray-800 rounded hover:bg-gray-300 dark:hover:bg-gray-800"
                    >
                        Action 1
                    </button>
                    <button
                        class="flex items-center justify-center h-10 px-4 ml-2 text-sm font-medium active:bg-gray-200 active:dark:bg-gray-800 rounded hover:bg-gray-300 dark:hover:bg-gray-800"
                    >
                        Action 2
                    </button>
                    <button
                        class="relative ml-2 text-sm focus:outline-none group"
                    >
                        <div
                            class="flex items-center justify-between w-10 h-10 rounded hover:bg-gray-300 dark:hover:bg-gray-800"
                        >
                            <svg
                                class="w-5 h-5 mx-auto"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"
                                />
                            </svg>
                        </div>
                        <div
                            class="absolute right-0 flex-col items-start hidden w-40 pb-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-800 shadow-lg group-focus:flex"
                        >
                            <a
                                class="w-full px-4 py-2 text-left hover:bg-gray-300 dark:hover:bg-gray-900"
                                href="#"
                                >Menu Item 1</a
                            >
                            <a
                                class="w-full px-4 py-2 text-left hover:bg-gray-300 dark:hover:bg-gray-900"
                                href="#"
                                >Menu Item 1</a
                            >
                            <a
                                class="w-full px-4 py-2 text-left hover:bg-gray-300 dark:hover:bg-gray-900"
                                href="#"
                                >Menu Item 1</a
                            >
                        </div>
                    </button>
                    @endif
                </div>
