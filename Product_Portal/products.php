<?php
include 'includes/db.php';

// pagination logic
$per_page = 9;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$start = ($page - 1) * $per_page;

// get total products for pagination
$count_sql = "SELECT COUNT(*) as total FROM products WHERE status='approved'";
$count_result = $conn->query($count_sql);
$total_rows = $count_result ? $count_result->fetch_assoc()['total'] : 0;
$total_pages = ceil($total_rows / $per_page);

// fetch products for current page
$sql = "SELECT * FROM products WHERE status='approved' LIMIT $start, $per_page";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Product Portal</title>

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- FontAwesome CSS -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-pO1A3BlCjBy7AijOqCcn43AJIV8CmbRBRjca+boI7cu4qSy5cI+3j3CRf10uLOuT4lwLVbqau+FdlFTOk6A2DQ=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  />

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #667eea, #764ba2);
    }
    .card-img {
      transition: transform 0.8s ease;
      will-change: transform;
    }
    .card:hover .card-img {
      transform: scale(1.1);
    }

    /* Mobile menu animation */
    #mobile-menu {
      max-height: 0;
      opacity: 0;
      overflow: hidden;
      transition: max-height 0.5s ease, opacity 0.5s ease;
    }
    #mobile-menu.open {
      max-height: 1000px; /* large enough for all links */
      opacity: 1;
      overflow: visible;
    }
  </style>
</head>

<body class="text-gray-800 overflow-x-hidden font-sans">

  <!-- Navbar -->
  <nav class="sticky top-0 bg-opacity-90 shadow-md z-50">
    <div class="max-w-7xl mx-auto px-6">
      <div class="flex justify-between items-center h-16">
        <a href="#hero" class="text-white text-xl font-bold tracking-wide hover:text-yellow-400 transition">
          Product Portal
        </a>
        <div class="hidden md:flex space-x-8 text-white text-lg font-semibold">
          <a href="index.php" class="hover:text-yellow-400 transition">Home</a>
          <a href="#products" class="hover:text-yellow-400 transition">Products</a>
          <a href="#about" class="hover:text-yellow-400 transition">About</a>
          <a href="#how" class="hover:text-yellow-400 transition">How It Works</a>
          <a href="#cta" class="hover:text-yellow-400 transition">Sell Now</a>
        </div>
        <div class="md:hidden">
          <button id="menu-btn" aria-label="Toggle menu" class="text-white focus:outline-none focus:ring-2 focus:ring-yellow-400">
            <i id="menu-icon" class="fas fa-bars fa-lg"></i>
          </button>
        </div>
      </div>
    </div>
    <div id="mobile-menu" class="md:hidden bg-indigo-900 bg-opacity-95">
      <a href="index.php" class="block px-6 py-3 text-white hover:bg-indigo-700 hover:text-yellow-400 transition">Home</a>
      <a href="#products" class="block px-6 py-3 text-white hover:bg-indigo-700 hover:text-yellow-400 transition">Products</a>
      <a href="#about" class="block px-6 py-3 text-white hover:bg-indigo-700 hover:text-yellow-400 transition">About</a>
      <a href="#how" class="block px-6 py-3 text-white hover:bg-indigo-700 hover:text-yellow-400 transition">How It Works</a>
      <a href="#cta" class="block px-6 py-3 text-white hover:bg-indigo-700 hover:text-yellow-400 transition">Sell Now</a>
    </div>
  </nav>

  <!-- Hero Section -->
  <section id="hero" class="hero flex flex-col items-center justify-center text-center px-6 py-24 text-white">
    <h1 class="text-5xl md:text-6xl font-extrabold mb-4 drop-shadow-lg">Welcome to Product Portal</h1>
    <p class="text-xl md:text-2xl max-w-3xl mb-8 drop-shadow-md">Explore top-rated products submitted by sellers and approved by admins</p>
    <a href="seller.php" class="inline-block bg-white text-indigo-800 font-semibold px-8 py-3 rounded-full shadow-lg hover:bg-yellow-400 hover:text-indigo-900 transition transform hover:scale-105">Become a Seller</a>
  </section>

  <!-- Products Section -->
  <section id="products" class="products-section bg-indigo-900 bg-opacity-30 py-16 px-6">
    <h2 class="section-title text-center text-4xl font-extrabold text-white mb-12 drop-shadow-lg tracking-wide">Featured Products</h2>
    <div class="max-w-7xl mx-auto grid gap-10 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
      <?php if ($result && $result->num_rows > 0):
        $delay = 0;
        $delayIncrement = 350;
        while ($row = $result->fetch_assoc()):
          $delay += $delayIncrement;
      ?>
        <article class="card bg-white rounded-xl shadow-lg overflow-hidden flex flex-col hover:shadow-2xl transition-shadow duration-500 cursor-default h-full" style="transition-delay: <?= $delay ?>ms;">
          <a href="product.php?id=<?= $row['id'] ?>" class="block group focus:outline-none h-full flex flex-col">
            <div class="overflow-hidden">
              <img
                src="<?= htmlspecialchars($row['image']) ?>"
                alt="<?= htmlspecialchars($row['name']) ?>"
                class="card-img w-full h-56 object-cover rounded-t-xl group-hover:scale-110 transition-transform duration-700"
                loading="lazy"
              />
            </div>
            <div class="p-6 flex flex-col flex-grow justify-between">
              <div>
                <h3 class="text-indigo-900 font-extrabold text-2xl mb-0 leading-snug min-h-[4.5rem]"><?= htmlspecialchars($row['name']) ?></h3>
                <p class="text-gray-700 mb-2 text-base leading-relaxed line-clamp-3"><?= htmlspecialchars($row['specs']) ?></p>
                <p class="text-green-600 font-extrabold text-xl mb-4 tracking-wide">$<?= number_format($row['price'], 2) ?></p>
              </div>
              <button
                onclick="window.location.href='product.php?id=<?= $row['id'] ?>'"
                class="desc-btn bg-indigo-700 text-white rounded-full py-3 px-8 font-semibold shadow-md hover:bg-indigo-800 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition text-lg"
                type="button"
              >
                View Description
              </button>
            </div>
          </a>
        </article>
      <?php endwhile; else: ?>
        <p class="text-center text-gray-200 text-lg">No approved products yet. Check back soon!</p>
      <?php endif; ?>
    </div>

    <?php if ($total_pages > 1): ?>
      <div class="flex justify-center mt-12 space-x-4">
        <?php if ($page > 1): ?>
          <a href="?page=<?= $page - 1 ?>" class="inline-flex items-center bg-indigo-700 text-white px-6 py-3 rounded-full shadow hover:bg-indigo-800 transition duration-300">
  <!-- Back Arrow Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Prev
          </a>

        <?php endif; ?>
        <?php if ($page < $total_pages): ?>
          <a href="?page=<?= $page + 1 ?>" class="bg-indigo-700 text-white px-6 py-3 rounded-full shadow hover:bg-indigo-800 transition">
            Next ➡️
          </a>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </section>

  <!-- About Section -->
  <section id="about" class="about text-white py-20 px-6 text-center">
    <div class="max-w-4xl mx-auto">
      <h2 class="text-4xl font-extrabold mb-6 drop-shadow-lg tracking-wide">What is Product Portal?</h2>
      <p class="text-xl leading-relaxed drop-shadow-md">
        Product Portal is a transparent marketplace where anyone can list their product for free.
        Admins verify every item, ensuring authenticity and trust for buyers. Simple, safe, and effective.
      </p>
    </div>
  </section>

  <!-- How It Works Section -->
  <section id="how" class="how-it-works bg-indigo-800 bg-opacity-80 py-20 px-6">
    <div class="max-w-3xl mx-auto text-white text-center">
      <h2 class="text-4xl font-extrabold mb-10 tracking-wide drop-shadow-lg">How It Works</h2>
      <div class="space-y-8 text-lg leading-relaxed">
        <p><strong>1.</strong> Seller submits product details using our online form.</p>
        <p><strong>2.</strong> Admin reviews and approves the submission.</p>
        <p><strong>3.</strong> Approved products are displayed here for buyers to browse.</p>
      </div>
    </div>
  </section>

  <!-- Call to Action -->
  <section id="cta" class="cta py-20 px-6 text-center text-white">
    <h2 class="text-4xl font-extrabold mb-6 tracking-wide drop-shadow-md">Got Something to Sell?</h2>
    <p class="text-xl max-w-3xl mx-auto mb-8 drop-shadow-sm">
      Join hundreds of sellers already listing their best items. It's quick and easy.
    </p>
    <a href="seller.php" class="inline-block bg-indigo-900 text-yellow-400 font-bold px-10 py-3 rounded-full shadow-lg hover:bg-indigo-800 hover:text-yellow-300 transition transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-yellow-300">
      Submit a Product Now
    </a>
  </section>

  <!-- Footer -->
  <footer class="super-footer bg-indigo-900 text-gray-300 py-16 px-6">
    <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-12">
      <div>
        <h5 class="text-white text-xl font-bold mb-4 tracking-wide">About Product Portal</h5>
        <p class="leading-relaxed">
          We connect sellers and buyers with trust and transparency. Our mission is to make buying and selling seamless and secure.
        </p>
      </div>
      <div>
        <h5 class="text-white text-xl font-bold mb-4 tracking-wide">Quick Links</h5>
        <ul class="space-y-2">
          <li><a href="#hero" class="hover:text-yellow-400 transition">Home</a></li>
          <li><a href="#products" class="hover:text-yellow-400 transition">Products</a></li>
          <li><a href="#about" class="hover:text-yellow-400 transition">About</a></li>
          <li><a href="#how" class="hover:text-yellow-400 transition">How It Works</a></li>
          <li><a href="#cta" class="hover:text-yellow-400 transition">Sell Now</a></li>
        </ul>
      </div>
      <div>
        <h5 class="text-white text-xl font-bold mb-4 tracking-wide">Contact Us</h5>
        <p>Email: <a href="mailto:support@productportal.com" class="hover:text-yellow-400 transition">support@productportal.com</a></p>
        <p>Phone: <a href="tel:+15551234567" class="hover:text-yellow-400 transition">+1 555 123 4567</a></p>
        <div class="social-icons mt-4 flex space-x-6 text-yellow-400 text-2xl">
          <a href="#" aria-label="Facebook" class="hover:text-yellow-300"><i class="fab fa-facebook-f"></i></a>
          <a href="#" aria-label="Twitter" class="hover:text-yellow-300"><i class="fab fa-twitter"></i></a>
          <a href="#" aria-label="Instagram" class="hover:text-yellow-300"><i class="fab fa-instagram"></i></a>
          <a href="#" aria-label="LinkedIn" class="hover:text-yellow-300"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>
    </div>
    <div class="mt-16 border-t border-indigo-700 pt-6 text-center text-sm text-indigo-400 select-none">
      &copy; <?= date("Y") ?> Product Portal | Crafted with ❤️ by You
    </div>
  </footer>

  <script>
    const menuBtn = document.getElementById('menu-btn');
    const menuIcon = document.getElementById('menu-icon');
    const mobileMenu = document.getElementById('mobile-menu');
    const links = mobileMenu.querySelectorAll('a');

    let menuOpen = false;

    menuBtn.addEventListener('click', () => {
      menuOpen = !menuOpen;
      if (menuOpen) {
        mobileMenu.classList.add('open');
        menuIcon.classList.remove('fa-bars');
        menuIcon.classList.add('fa-times');
      } else {
        mobileMenu.classList.remove('open');
        menuIcon.classList.remove('fa-times');
        menuIcon.classList.add('fa-bars');
      }
    });

    links.forEach(link => {
      link.addEventListener('click', () => {
        mobileMenu.classList.remove('open');
        menuIcon.classList.remove('fa-times');
        menuIcon.classList.add('fa-bars');
        menuOpen = false;
      });
    });
  </script>

  <!-- Font Awesome JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <!-- ScrollReveal -->
  <script src="https://unpkg.com/scrollreveal"></script>
  <script>
    const sr = ScrollReveal({
      origin: 'top',
      distance: '60px',
      duration: 2000,
      delay: 200,
      easing: 'cubic-bezier(0.6, 0, 0.4, 2)',
      reset: false
    });
    sr.reveal('#hero h1, #hero p, #hero a', { interval: 200 });
    sr.reveal('.section-title', { origin: 'bottom' });
    sr.reveal('.products-section article', { interval: 200, origin: 'bottom' });
    sr.reveal('#about div, #about p', { interval: 200 });
    sr.reveal('#how div > *', { interval: 200 });
    sr.reveal('#cta h2, #cta p, #cta a', { interval: 200 });
    sr.reveal('footer div, footer p, footer a', { interval: 200 });
  </script>

</body>
</html>
