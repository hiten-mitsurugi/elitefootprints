<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: index.php");
    exit();
}

// Logout functionality
if (isset($_POST['logout'])) {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page
    header("Location: index.php");
    exit();
}

// Include the database connection file
include 'connects.php';

// Retrieve logged-in user's information from the database
$user_id = $_SESSION['user_id'];
$query_user = "SELECT * FROM users WHERE user_id = $1";
$result_user = pg_query_params($connect, $query_user, array($user_id));

// Check if the user query was successful
if ($result_user) {
    $user = pg_fetch_assoc($result_user);
} else {
    echo "Error fetching user details: " . pg_last_error($connect);
    exit();
}

// Retrieve product data from the database
$query_products = "SELECT * FROM active_products_view WHERE status_id = $1 ORDER BY product_name ASC";
$result_products = pg_query_params($connect, $query_products, array(1)); // 1 is the value for status_id

// Fetch products or initialize to empty array
if ($result_products) {
    $products = pg_fetch_all($result_products) ?: []; // Fetch results or set to empty array
} else {
    $products = []; // Safe fallback
    echo "Error fetching products: " . pg_last_error($connect);
}
?>

<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Realistic shadow effect */
        .realistic-shadow {
            filter: drop-shadow(0px 10px 15px rgba(0, 0, 0, 0.25));
        }

        /* Custom cursor effect */
        .hover-cursor {
            cursor: pointer;
        }
    </style>
</head>

<body class="bg-black text-gray-100">
    
    <!-- Navbar -->
    <nav class="p-6 bg-gray-800 text-white flex justify-between">
        <h1 class="text-3xl font-bold">E-commerce Site</h1>
        <form method="post">
            <button type="submit" name="logout" class="bg-red-500 px-4 py-2 rounded hover:bg-red-600">Logout</button>
        </form>
    </nav>

    <!-- Trending Products Section -->
    <section class="p-8">
        <h2 class="text-4xl font-bold mb-8">Trending Products</h2>

        <?php if (empty($products)): ?>
            <p class="text-center text-gray-500">No products available at the moment.</p>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php foreach ($products as $product): ?>
                    <div class="bg-gray-200 text-black p-6 rounded-lg shadow-lg relative hover-cursor">
                        <!-- Product Image with Realistic Shadow -->
                        <div class="flex justify-center items-center mb-6">
                            <img src="assets/product/<?= htmlspecialchars($product['image_url']) ?>"
                                alt="<?= htmlspecialchars($product['product_name']) ?>" class="w-[90%] object-contain transform hover:scale-110 transition-transform duration-400 ease-in-out 
                drop-shadow-[0_50px_20px_#0009]  border-none" />
                        </div>


                        <!-- Product Name -->
                        <h3 class="text-xl font-semibold text-center mb-2">
                            <?= htmlspecialchars($product['product_name']) ?>
                        </h3>

                        <!-- Price -->
                        <p class="text-center text-gray-600 mb-4">
                            $<?= number_format($product['selling_price'], 2) ?>
                        </p>

                        <!-- Add to Cart Button -->
                        <button
                            class="bg-gray-800 text-white px-4 py-2 w-full rounded hover:bg-green-500 hover:scale-105 transition-all duration-300 cursor-pointer">
                            Add to Cart
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</body>

</html>