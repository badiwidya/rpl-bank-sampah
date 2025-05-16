<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bank Sampah</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white font-sans">


  <!-- Header -->
  <header class="flex justify-between items-center px-8 py-4 bg-white border-b shadow-sm">
    <div class="flex items-center space-x-2 font-semibold text-lg">
      <img src="/public/Group.png" alt="logo" class="w-6 h-6" />
      <span>Bank Sampah</span>
    </div>
    <nav class="space-x-6 text-sm font-medium">
      <a href="#" class="text-gray-700 hover:text-green-600">Home</a>
      <a href="#" class="text-gray-700 hover:text-green-600">About Us</a>
      <a href="#" class="text-gray-700 hover:text-green-600">Profile</a>
    </nav>
  </header>


  <!-- Main Content -->
  <div class="flex h-[calc(100vh-72px)]">
    <!-- Left Panel -->
    <div class="w-1/2 bg-gradient-to-b from-[#0eb784] to-[#003d26] flex flex-col items-center justify-center text-white px-8">
      <img src="https://i.ibb.co/0jTKTm7/earth-tree.png" alt="Earth with Trees" class="w-72 mb-8" />
      <p class="text-center text-sm max-w-md">
        "Dengan memanfaatkan bank sampah, kita ikut berperan aktif dalam menjaga ekosistem dan memastikan bumi tetap lestari untuk generasi mendatang."
      </p>
    </div>


    <!-- Right Panel -->
    <div class="w-1/2 flex items-center justify-center bg-white">
      <div class="bg-white p-8 rounded-xl shadow-2xl border border-gray-100 w-80 text-center hover:shadow-green-200 transition">
        <div class="flex justify-center mb-4">
          <img src="https://img.icons8.com/ios-filled/50/0eb784/user-male-circle.png" alt="User Icon" class="w-12 h-12" />
        </div>
        <h2 class="text-lg font-semibold">Login Sebagai</h2>
        <p class="text-gray-500 text-sm mb-6">Akses Akun Setoran Sampah</p>


        <!-- Admin Button as Anchor -->
        <a href="/admin/login" class="block bg-gray-800 text-white w-full py-2 rounded-md mb-3 hover:bg-gray-700 transition">Admin</a>


        <!-- Pengguna Button -->
        <a href="/nasabah/login" class="block bg-green-600 text-white w-full py-2 rounded-md hover:bg-green-700 transition">Pengguna</a>


        <p class="mt-6 text-xs text-gray-500">
          Tidak Memiliki Akun? <a href="#" class="text-green-600 hover:underline">Daftar Disini</a>
        </p>
      </div>
    </div>
  </div>


</body>
</html>

