<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="style.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              primary: "#05022B",
              secondary: "#7B79FF",
              tetiary: "#B7B6FF",
            },
          },
        },
      };
    </script>
    <title>Developer</title>
  </head>
  <body>
    <div class="antialiased bg-gray-50 ">
      @if ($errors->any())
      <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700" role="alert">
      <span class="font-medium">Error!</span>
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
      </div>
      @endif

      
      @if (session('success'))
      <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
      <span class="font-medium">Success!</span>
      <ul>
          <li>{{ session('success') }}</li>
      </ul>
      </div>
      <br>
      @endif

      @if (session('error'))
      <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700" role="alert">
      <span class="font-medium">Error!</span>
      <ul>
          <li>{{ session('error') }}</li>
      </ul>
      </div>
      <br>
      

      @endif
        @yield("content")
    </div>
</body>
</html>