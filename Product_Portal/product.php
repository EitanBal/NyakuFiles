<?php
include 'includes/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM products WHERE id = $id AND status='approved'";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    header('Location: index.php');
    exit;
}

$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($product['name']) ?> | Product Portal</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

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

    .product-hero {
      background: linear-gradient(135deg, #4e54c8, #8f94fb);
      padding: 60px 20px;
      color: #fff;
      text-align: center;
    }

    .product-hero h1 {
      font-weight: 700;
      font-size: 2.5rem;
    }

    .product-section {
      padding: 60px 20px;
      background: #f5f7fa;
    }

    .btn-buy {
      background: linear-gradient(135deg, #28a745, #85e085);
      color: #fff;
      border: none;
      padding: 12px 30px;
      font-weight: 600;
      border-radius: 50px;
      text-decoration: none;
      display: inline-block;
      transition: 0.3s ease;
    }

    .btn-buy:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
      color: #fff;
    }

    footer {
      background: #222;
      color: #ccc;
      text-align: center;
      padding: 20px;
      font-size: 0.9rem;
    }

    .product-image-wrapper {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 15px 30px rgba(0,0,0,0.2);
      transition: transform 0.3s;
    }

    .product-image-wrapper:hover {
      transform: scale(1.05);
    }

    .product-image {
      width: 100%;
      height: 400px;
      object-fit: contain;
      border-radius: 8px;
      background: linear-gradient(135deg, #e0eafc, #cfdef3);
    }

    @media (max-width: 768px) {
      .product-hero h1 {
        font-size: 2rem;
      }
      .product-image {
        height: 250px;
      }
    }
  </style>
</head>

<body>

  <!-- Sticky Navbar -->
  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
      <a class="navbar-brand" href="index.php">Product Portal</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="products.php">Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="product-hero">
    <h1><?= htmlspecialchars($product['name']) ?></h1>
    <p class="lead">Discover amazing details and get yours now!</p>
  </section>

  <section class="product-section">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-md-6 text-center">
          <div class="product-image-wrapper">
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="Product Image" class="product-image">
          </div>
        </div>
        <div class="col-md-6">
          <h2 class="text-primary"><?= htmlspecialchars($product['name']) ?></h2>
          <p class="lead"><?= nl2br(htmlspecialchars($product['specs'])) ?></p>
          <h4 class="text-success">$<?= number_format($product['price'], 2) ?></h4>
          <a href="checkout.php?id=<?= $product['id'] ?>" class="btn-buy mt-3">Buy Now</a>
        </div>
      </div>
    </div>
  </section>

  <footer>
    &copy; <?= date("Y") ?> Product Portal | Crafted with ❤️ by You
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    ScrollReveal().reveal('.navbar', {
      duration: 1000,
      origin: 'top',
      distance: '50px',
      easing: 'ease-out',
      opacity: 0
    });

    ScrollReveal().reveal('.product-hero', {
      duration: 1200,
      origin: 'bottom',
      distance: '60px',
      opacity: 0,
      easing: 'ease-out'
    });

    ScrollReveal().reveal('.product-image-wrapper', {
      duration: 1200,
      origin: 'left',
      distance: '50px',
      opacity: 0,
      easing: 'ease-out'
    });

    ScrollReveal().reveal('.product-section .col-md-6:nth-child(2)', {
      duration: 1200,
      origin: 'right',
      distance: '50px',
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
