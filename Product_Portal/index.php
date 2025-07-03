<?php 
include 'includes/db.php';

// Fetch recent products
$sql = "SELECT * FROM products WHERE status = 'approved' ORDER BY id DESC LIMIT 3";
$result = $conn->query($sql);
$recent_products = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recent_products[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Product Portal | Home</title>

  <!-- Bootstrap & Google Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />

  <!-- ScrollReveal -->
  <script src="https://unpkg.com/scrollreveal"></script>

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: #333;
      overflow-x: hidden;
    }

    .navbar {
      background: linear-gradient(135deg, #4e54c8, #8f94fb);
    }

    .navbar-brand {
      font-weight: 700;
      color: #fff;
    }

    .navbar-nav .nav-link {
      color: #fff;
      font-weight: 600;
      transition: color 0.3s;
    }

    .navbar-nav .nav-link:hover {
      color: #ffd700;
    }

    .sticky-top {
      position: sticky;
      top: 0;
      z-index: 1020;
    }

    .hero {
      background: linear-gradient(135deg, #4e54c8, #8f94fb);
      color: #fff;
      padding: 100px 20px;
      text-align: center;
    }

    .hero h1 {
      font-weight: 700;
      font-size: 3rem;
      margin-bottom: 20px;
    }

    .hero p {
      font-size: 1.2rem;
      margin-bottom: 30px;
    }

    .hero a {
      padding: 12px 30px;
      font-weight: 600;
      background: #fff;
      color: #4e54c8;
      border-radius: 50px;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .hero a:hover {
      background: #f5f5f5;
      color: #222;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    .section-title {
      color: #fff;
      text-align: center;
      font-weight: 700;
      margin-top: 60px;
      margin-bottom: 40px;
      font-size: 2.2rem;
    }

    .features,
    .reviews {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 40px;
      margin-bottom: 60px;
    }

    .feature-card,
    .review-card {
      background: #fff;
      color: #333;
      border-radius: 12px;
      padding: 30px;
      width: 300px;
      text-align: center;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
      transition: all 0.3s ease;
    }

    .feature-card:hover,
    .review-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
    }

    .products-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 30px;
      margin-bottom: 60px;
    }

    .product-card {
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
      transition: all 0.3s ease;
      text-align: center;
    }

    .product-card img {
      width: 100%;
      height: 200px;
      object-fit: contain;
      background: linear-gradient(135deg, #e0eafc, #cfdef3);
    }

    .product-card h5 {
      margin: 15px 0 5px;
      color: #4e54c8;
      font-weight: 700;
    }

    .product-card p {
      margin-bottom: 15px;
      color: #28a745;
      font-weight: 600;
    }

    .product-card a {
      margin-bottom: 15px;
      display: inline-block;
      padding: 8px 20px;
      font-weight: 600;
      background: linear-gradient(135deg, #28a745, #85e085);
      color: #fff;
      border-radius: 50px;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .product-card a:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
      color: #fff;
    }

    footer {
      background: #222;
      color: #ccc;
      text-align: center;
      padding: 20px;
      font-size: 0.9rem;
    }

    @media (max-width: 768px) {
      .hero h1 {
        font-size: 2rem;
      }
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
      <a class="navbar-brand" href="index.php">Product Portal</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
          <li class="nav-item"><a class="nav-link" href="seller.php">Become a Seller</a></li>
          <li class="nav-item"><a class="nav-link" href="admin/login.php">Admin Login</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero">
    <h1>Welcome to Product Portal</h1>
    <p>Discover unique products. Submit yours for free. Shop with confidence.</p>
    <a href="products.php">Browse Products</a>
  </section>

  <!-- Features -->
  <section>
    <h2 class="section-title">Why Choose Product Portal?</h2>
    <div class="container">
      <div class="features">
        <div class="feature-card">
          <h4>100% Free Listing</h4>
          <p>Any seller can list products without fees. Simple, fair, and open for everyone.</p>
        </div>
        <div class="feature-card">
          <h4>Admin Approval</h4>
          <p>We manually approve products to ensure quality, safety, and authenticity.</p>
        </div>
        <div class="feature-card">
          <h4>Secure Checkout</h4>
          <p>Buyers can choose payment methods, including Mobile Money and Cash on Delivery.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Recent Products -->
  <section>
    <h2 class="section-title">Latest Products</h2>
    <div class="container">
      <div class="products-grid">
        <?php if (!empty($recent_products)) : ?>
          <?php foreach ($recent_products as $product): ?>
            <div class="product-card">
              <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
              <h5><?= htmlspecialchars($product['name']) ?></h5>
              <p>$<?= number_format($product['price'], 2) ?></p>
              <a href="product.php?id=<?= $product['id'] ?>">View Product</a>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-center text-light">No recent products available.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Reviews -->
  <section>
    <h2 class="section-title">What People Are Saying</h2>
    <div class="container">
      <div class="reviews">
        <div class="review-card">
          <h5>Jane Doe</h5>
          <p>“I love how easy it was to list my product. It sold within a week!”</p>
        </div>
        <div class="review-card">
          <h5>Michael Smith</h5>
          <p>“The approval process gives me peace of mind. Great platform!”</p>
        </div>
        <div class="review-card">
          <h5>Sarah Lee</h5>
          <p>“Secure checkout is a game changer. I feel safe buying here.”</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="hero" style="padding: 60px 20px;">
    <h2 style="font-size: 2.5rem;">Ready to List Your Product?</h2>
    <p>Join hundreds of sellers showcasing their amazing products to the world.</p>
    <a href="seller.php">Start Selling Now</a>
  </section>

  <!-- Footer -->
  <footer>
    &copy; <?= date('Y') ?> Product Portal | Crafted with ❤️ by You
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    ScrollReveal().reveal('.navbar', {
      duration: 1000,
      origin: 'top',
      distance: '50px',
      easing: 'ease-out',
      opacity: 0
    });

    ScrollReveal().reveal('.hero', {
      duration: 1200,
      origin: 'bottom',
      distance: '60px',
      opacity: 0,
      easing: 'ease-out'
    });

    ScrollReveal().reveal('.section-title', {
      duration: 1000,
      origin: 'bottom',
      distance: '40px',
      delay: 200,
      opacity: 0,
      easing: 'ease-out'
    });

    ScrollReveal().reveal('.feature-card', {
      duration: 1000,
      interval: 200,
      origin: 'bottom',
      distance: '40px',
      opacity: 0,
      easing: 'ease-out'
    });

    ScrollReveal().reveal('.product-card', {
      duration: 1000,
      interval: 200,
      origin: 'bottom',
      distance: '40px',
      opacity: 0,
      easing: 'ease-out'
    });

    ScrollReveal().reveal('.review-card', {
      duration: 1000,
      interval: 200,
      origin: 'bottom',
      distance: '40px',
      opacity: 0,
      easing: 'ease-out'
    });

    ScrollReveal().reveal('footer', {
      duration: 1000,
      origin: 'bottom',
      distance: '40px',
      opacity: 0,
      easing: 'ease-out'
    });
  </script>

</body>
</html>
