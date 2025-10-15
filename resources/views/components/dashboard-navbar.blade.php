<nav class="bg-white border-b border-gray-200 px-4 py-3 dark:bg-gray-800 dark:border-gray-700 fixed left-0 right-0 top-0 z-50 h-16 md:h-[4.5rem]">
    <div class="flex flex-wrap justify-between items-center">
        <div class="flex justify-start items-center">

            <button 
                @click="isSidebarOpen = !isSidebarOpen"
                class="md:hidden p-2 mr-2 text-gray-600 rounded-lg cursor-pointer hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-100 dark:text-gray-400 dark:hover:text-white dark:focus:ring-gray-700">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
            </button>

            <a href="{{ url('/') }}" class="flex items-center justify-between mr-4">    
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white"> &lt;/&gt; Dashboard TVRI Yogyakarta</span>
            </a>
        </div>

        <div class="flex items-center lg:order-2" x-data="{ dropdownOpen: false }">
            <!-- Notifikasi Button -->
            <button type="button" 
                class="p-2 mr-1 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600">
                <span class="sr-only">View notifications</span>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                </svg>
            </button>

            <!-- User Menu Dropdown -->
            <div class="relative">
                <button 
                    type="button" 
                    @click="dropdownOpen = !dropdownOpen"
                    @click.away="dropdownOpen = false"
                    class="flex mx-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-8 h-8 rounded-full" 
                         src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random&color=fff" 
                         alt="user photo" />
                </button>

                <!-- Dropdown Menu -->
                <div 
                    x-show="dropdownOpen"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute right-0 z-50 my-4 w-56 text-base list-none bg-white divide-y divide-gray-100 shadow-lg dark:bg-gray-700 dark:divide-gray-600 rounded-xl"
                    style="display: none;">
                    
                    <div class="py-3 px-4">
                        <span class="block text-sm font-semibold text-gray-900 dark:text-white">{{ auth()->user()->name }}</span>
                        <span class="block text-sm text-gray-500 truncate dark:text-gray-400">{{ auth()->user()->email }}</span>
                    </div>

                    <ul class="py-1 text-gray-700 dark:text-gray-300">
                        <li>
                            <a href="#" class="block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white">
                                My profile
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white">
                                Account settings
                            </a>
                        </li>
                    </ul>

                    <ul class="py-1 text-gray-700 dark:text-gray-300">
                        <li>
                            <form action="/logout" method="POST">
                                @csrf
                                <button type="submit" 
                                    class="block w-full text-left py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    Sign out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>