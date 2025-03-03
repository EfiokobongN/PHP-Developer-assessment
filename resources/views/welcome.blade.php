@extends('Layout.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-lg">
               
    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="POST" action="{{ route('user.login') }}">
        @csrf
        <h1 class="mb-6 text-gray-700 text-lg font-bold">Freedom Technologies User Login</h1>
       
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                Email
            </label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="email" type="text" name="email" placeholder="Enter your email address" required>
        </div> 

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                Password
            </label>
            <input
                class="shadow appearance-none border border-blue-800 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                id="password" type="password" name="password" placeholder="******************" required>
            <p class="text-red-500 text-xs italic">Please choose a password.</p>
        </div>

        

        <div class="mb-6">
            <button
                class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 shadow appearance-none border border-blue-500 rounded w-full"
                type="submit">
                Sign In
            </button>
        </div>
        <div class="flex items-center justify-between">
            <p class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Don't Have An Account?
            </p>
            <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('user.account') }}">
               Sign Up
            </a>
        </div>
    </form>
    <p class="text-center text-gray-500 text-xs">
        &copy;2020 Freedom Technologies. All rights reserved.
    </p>
    </div>
</div>
@endsection


