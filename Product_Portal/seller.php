<?php include 'includes/db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="List your product for free on Product Portal and connect with thousands of potential buyers. Simple, fast, and secure.">
  <meta name="author" content="Product Portal Team" />

  <title>Submit Your Product | Product Portal</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>

<body class="min-h-screen flex flex-col bg-gradient-to-br from-indigo-700 via-purple-600 to-blue-400 overflow-x-hidden">

  <!-- Header -->
  <header class="w-full bg-white shadow-lg py-4 px-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-indigo-700">Product Portal</h1>
    <nav>
      <a href="index.php" class="text-indigo-700 font-semibold hover:text-indigo-900 transition">Home</a>
    </nav>
  </header>

  <!-- Main Content -->
  <main class="flex-grow flex justify-center items-center py-10 px-4">
    <div class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-lg transform transition-all duration-700 opacity-0 translate-y-10 scale-95" id="form-container">
      <h1 class="text-3xl font-bold text-center text-indigo-700 mb-2">📦 List Your Product</h1>
      <p class="text-center text-gray-600 mb-6">Reach thousands of buyers by showcasing what you sell. Get started in just 60 seconds!</p>

      <!-- Link to Products Page -->
      <a href="products.php" class="inline-block bg-gradient-to-r from-indigo-600 to-purple-500 text-white font-semibold py-2 px-4 rounded-lg hover:scale-105 transform transition mb-6 text-center w-full">← View All Products</a>

      <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div id="successMessage" class="bg-gradient-to-r from-green-500 to-green-400 text-white p-4 rounded-lg mb-4 flex justify-between items-center animate-fade-in">
          <span>✅ Product submitted successfully! Awaiting admin approval.</span>
          <button class="text-white text-xl font-bold hover:text-gray-200" onclick="document.getElementById('successMessage').style.display='none';">&times;</button>
        </div>
      <?php endif; ?>

      <div id="errorMessage" class="text-red-600 text-center mb-4 hidden">Please fill in all required fields.</div>

      <form id="productForm" action="submit.php" method="post" enctype="multipart/form-data" novalidate>
        <label for="name" class="font-semibold text-gray-700">Product Name <span class="text-red-600 font-bold">(required)</span></label>
        <input type="text" id="name" name="name" placeholder="Enter product name" required aria-required="true" minlength="3" maxlength="100" class="w-full border-2 border-gray-300 rounded-lg p-3 mb-4 focus:outline-none focus:border-indigo-600 transition" />

        <label for="specs" class="font-semibold text-gray-700">Specifications (optional)</label>
        <textarea id="specs" name="specs" placeholder="Tell us about your product..." class="w-full border-2 border-gray-300 rounded-lg p-3 mb-4 focus:outline-none focus:border-indigo-600 transition"></textarea>

        <label for="price" class="font-semibold text-gray-700">Price ($) <span class="text-red-600 font-bold">(required)</span></label>
        <input type="number" id="price" name="price" placeholder="0.00" min="0" step="0.01" required aria-required="true" class="w-full border-2 border-gray-300 rounded-lg p-3 mb-4 focus:outline-none focus:border-indigo-600 transition" />

        <label for="image" class="font-semibold text-gray-700">Product Image <span class="text-red-600 font-bold">(required)</span></label>
        <input type="file" id="image" name="image" accept="image/*" required aria-required="true" class="w-full border-2 border-gray-300 rounded-lg p-3 mb-6 focus:outline-none focus:border-indigo-600 transition" />

        <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-500 text-white font-bold py-3 rounded-lg hover:scale-105 transform transition duration-300">📤 Submit Product</button>
      </form>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-indigo-700 text-white text-center py-4 mt-auto text-sm font-semibold shadow-inner">
    &copy; <?= date("Y") ?> Product Portal &mdash; All rights reserved.
  </footer>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const container = document.getElementById('form-container');
      container.classList.remove('opacity-0', 'translate-y-10', 'scale-95');
      container.classList.add('opacity-100', 'translate-y-0', 'scale-100');

      const form = document.getElementById('productForm');
      const errorMessage = document.getElementById('errorMessage');

      form.addEventListener('submit', (e) => {
        let valid = true;

        form.querySelectorAll('input[required], textarea[required]').forEach(input => {
          if (!input.value.trim()) {
            input.classList.add('border-red-500');
            valid = false;
          } else {
            input.classList.remove('border-red-500');
          }
        });

        if (!valid) {
          e.preventDefault();
          errorMessage.classList.remove('hidden');
        } else {
          errorMessage.classList.add('hidden');
        }
      });
    });
  </script>
</body>
</html>
