<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bank Sampah - Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('bg.jpeg') }}');">  
  <!-- Header -->
  <header class="flex justify-between items-center px-8 py-4 bg-white shadow">
    <div class="flex items-center space-x-2 font-semibold text-lg">
      <img src="https://img.icons8.com/ios-filled/24/0eb784/recycle.png" alt="logo" class="w-6 h-6" />
      <span>Bank Sampah</span>
    </div>
    <nav class="space-x-6 text-sm font-medium">
      <a href="#" class="text-gray-700 hover:text-green-600">Home</a>
      <a href="#" class="text-gray-700 hover:text-green-600">About Us</a>
      <a href="#" class="text-gray-700 hover:text-green-600">Profile</a>
    </nav>
  </header>

  <!-- Login Form -->
  <div class="flex justify-center items-center min-h-[calc(100vh-80px)] px-4">
    <div class="bg-white bg-opacity-90 backdrop-blur-md p-8 rounded-xl shadow-xl w-full max-w-md">
      <div class="flex justify-center mb-6">
        <img src="https://img.icons8.com/ios-filled/50/0eb784/user-male-circle.png" alt="User Icon" class="w-12 h-12" />
      </div>
      <h2 class="text-xl font-semibold text-center">Login Your Account</h2>
      <p class="text-center text-sm text-gray-500 mb-6">access your waste collection profile</p>
      
      <form onsubmit="return false;">
        <!-- Email -->
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Email/No. Telepon</label>
          <input type="text" placeholder="Masukkan Email/No. Telepon" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-400" />
        </div>

        <!-- Password -->
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
          <div class="relative">
            <input type="password" placeholder="Masukkan Password" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-400" />
            <span class="absolute inset-y-0 right-3 flex items-center cursor-pointer">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
              </svg>
            </span>
          </div>
        </div>

        <!-- Remember me & forgot -->
        <div class="flex justify-between items-center mb-6 text-sm">
          <label class="flex items-center space-x-2 text-gray-600">
            <input type="checkbox" class="form-checkbox text-green-600" />
            <span>Remember me</span>
          </label>
          <a href="#" class="text-green-500 hover:underline">Forgot Password?</a>
        </div>

        <!-- Login as Anchor -->
        <a href="/dashboard" class="block text-center w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-700 transition">
          Login
        </a>
      </form>

      <!-- Sign Up -->
      <p class="text-center text-sm text-gray-600 mt-6">
        Don't have an account? <a href="#" class="text-green-600 hover:underline">Sign Up</a>
      </p>
    </div>
  </div>

</body>
</html>
