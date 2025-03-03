@extends('Layout.app')

@section('content')



    <main class="p-4 md:ml-643 h-auto pt-4">
        <div class="lg:p-4 flex flex-col bg-white shadow p-4 rounded-lg min-h-screen">
            <h1 class="text-xl lg:text-2xl font-semibold text-gray-700 tracking-tight mb-4">
                User Customer Page Developer
            </h1>

            <div class="flex flex-col">
                <div class="flex p-2 items-center justify-between gap-4 lg:gap-6 mb-5 lg:mb-10">


                    <div class="max-w-lg mx-auto grow">
                        <h1>Customers List</h1>
                    </div>

                    <button type="button" data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                        class="grow text-white bg-blue-700 font-medium rounded-lg text-sm px-5 p-4 me-2">
                        New Customer
                    </button>
                </div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-red-600 bg-gray-50 sticky left-0 z-10">
                                    S/N
                                </th>
                                <th scope="col" class="px-6 py-3 text-red-600">Name</th>
                                <th scope="col" class="px-6 py-3 text-red-600">Email</th>
                                <th scope="col" class="px-6 py-3 text-red-600">Mobile Number</th>
                                <th scope="col" class="px-6 py-3 text-red-600">CV</th>
                                <th scope="col" class="px-6 py-3 text-red-600">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($userCustomers->count() > 0)
                                @foreach ($userCustomers as $index => $customer)
                                    <tr class="bg-white border-b hover:bg-gray-100">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-white sticky left-0">
                                            {{ $index + 1 }}
                                        </th>
                                        <td class="px-6 py-4">{{ $customer->customer_name }}</td>
                                        <td class="px-6 py-4">{{ $customer->customer_email }}</td>
                                        <td class="px-6 py-4">{{ $customer->customer_phone }}</td>
                                        <td class="px-6 py-4"><a
                                                class="text-secondary hover:font-semibold hover:underline cursor-pointer"
                                                href="{{ $customer->customer_cv }}">View Cv</a>
                                        </td>
                                        <td class="px-6 py-4">{{ $customer->created_at }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <p>No Customer Created Yet</p>
                            @endif

                        </tbody>
                    </table>
                </div>

                <nav class="self-end mt-4" aria-label="Page navigation example">
                    <ul class="inline-flex -space-x-px text-sm">
                        <li>
                            <a href="#"
                                class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700">Previous</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">1</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">2</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">3</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </main>

    <!-- Main modal -->
    <div id="crud-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Add Customer
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5" method="POST" action="{{ route('user.storeCustomer') }}" enctype="multipart/form-data">
                  @csrf
                    <div class="grid gap-4 mb-4 grid-cos-2">

                        <div class="max-h-full flex flex-col gap-3 justify-start">
                            <div class="col-span-2">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Customer
                                    Name</label>
                                <input type="text" name="customer_name" id="customer_name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-tetiary focus:border-tetiary block w-full p-2.5"
                                    placeholder="Enter Customer name" required />
                            </div>
                            <div class="col-span-2">
                              <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Customer
                                  Email</label>
                              <input type="text" name="customer_email" id="customer_email"
                                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-tetiary focus:border-tetiary block w-full p-2.5"
                                  placeholder="Enter Customer  Email" required />
                          </div>

                          <div class="col-span-2">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Customer
                                Phone Number</label>
                            <input type="text" name="customer_phone" id="customer_phone"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-tetiary focus:border-tetiary block w-full p-2.5"
                                placeholder="Enter Customer  Phone Number" required />
                        </div>

                        <div class="col-span-2">
                          <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Customer
                              Cv</label>
                          <input type="file" name="customer_cv" id="customer_cv"
                              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-tetiary focus:border-tetiary block w-full p-2.5"
                              placeholder="Upload Customer  Cv" required />
                      </div>

                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="submit"
                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Save Customer Recored
                        </button>

                        <button type="reset"
                            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2">
                            Clear Details
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
