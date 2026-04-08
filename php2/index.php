<?php
// =============================================
// PHP ELECTRONICS MARKETPLACE — index.php
// =============================================

// --- PHP: Product Data Array ---
$products = [
    ["id"=>1,  "name"=>"iPhone 15",          "category"=>"Mobile",      "price"=>79999,  "rating"=>4.8, "stock"=>"In Stock",    "brand"=>"Apple",    "inCart"=>true  ],
    ["id"=>2,  "name"=>"Samsung Galaxy S24", "category"=>"Mobile",      "price"=>64999,  "rating"=>4.6, "stock"=>"In Stock",    "brand"=>"Samsung",  "inCart"=>false ],
    ["id"=>3,  "name"=>"MacBook Air M2",     "category"=>"Laptop",      "price"=>114999, "rating"=>4.9, "stock"=>"Low Stock",   "brand"=>"Apple",    "inCart"=>true  ],
    ["id"=>4,  "name"=>"Dell XPS 15",        "category"=>"Laptop",      "price"=>89999,  "rating"=>4.5, "stock"=>"In Stock",    "brand"=>"Dell",     "inCart"=>false ],
    ["id"=>5,  "name"=>"Sony WH-1000XM5",    "category"=>"Audio",       "price"=>24999,  "rating"=>4.7, "stock"=>"In Stock",    "brand"=>"Sony",     "inCart"=>true  ],
    ["id"=>6,  "name"=>"AirPods Pro 2",      "category"=>"Audio",       "price"=>19999,  "rating"=>4.6, "stock"=>"In Stock",    "brand"=>"Apple",    "inCart"=>false ],
    ["id"=>7,  "name"=>"Logitech MX Master", "category"=>"Accessories", "price"=>7999,   "rating"=>4.5, "stock"=>"In Stock",    "brand"=>"Logitech", "inCart"=>true  ],
    ["id"=>8,  "name"=>'Samsung 65" QLED',   "category"=>"TV",          "price"=>94999,  "rating"=>4.4, "stock"=>"Low Stock",   "brand"=>"Samsung",  "inCart"=>false ],
    ["id"=>9,  "name"=>"Sony Alpha A7 IV",   "category"=>"Camera",      "price"=>229999, "rating"=>4.8, "stock"=>"Out of Stock","brand"=>"Sony",     "inCart"=>false ],
    ["id"=>10, "name"=>"OnePlus 12",         "category"=>"Mobile",      "price"=>49999,  "rating"=>4.4, "stock"=>"In Stock",    "brand"=>"OnePlus",  "inCart"=>true  ],
    ["id"=>11, "name"=>"HP Spectre x360",    "category"=>"Laptop",      "price"=>129999, "rating"=>4.6, "stock"=>"In Stock",    "brand"=>"HP",       "inCart"=>false ],
    ["id"=>12, "name"=>"JBL Charge 5",       "category"=>"Audio",       "price"=>13999,  "rating"=>4.3, "stock"=>"In Stock",    "brand"=>"JBL",      "inCart"=>true  ],
    ["id"=>13, "name"=>"Mechanical Keyboard","category"=>"Accessories", "price"=>4999,   "rating"=>4.2, "stock"=>"Out of Stock","brand"=>"Keychron", "inCart"=>false ],
    ["id"=>14, "name"=>'LG OLED 55"',        "category"=>"TV",          "price"=>119999, "rating"=>4.7, "stock"=>"In Stock",    "brand"=>"LG",       "inCart"=>true  ],
    ["id"=>15, "name"=>"Canon EOS R50",      "category"=>"Camera",      "price"=>74999,  "rating"=>4.5, "stock"=>"Low Stock",   "brand"=>"Canon",    "inCart"=>false ],
];

// --- PHP: Computed Stats ---
$totalProducts = count($products);
$inCartItems   = array_filter($products, fn($p) => $p["inCart"]);
$inCartCount   = count($inCartItems);
$cartTotal     = array_sum(array_column(array_values($inCartItems), "price"));
$outOfStock    = count(array_filter($products, fn($p) => $p["stock"] === "Out of Stock"));
$lowStock      = count(array_filter($products, fn($p) => $p["stock"] === "Low Stock"));

// --- PHP: Unique categories for filter ---
$categories = array_unique(array_column($products, "category"));
sort($categories);

// --- PHP: Helper: stock CSS class ---
function stockClass(string $stock): string {
    return match($stock) {
        "In Stock"    => "stock-in",
        "Low Stock"   => "stock-low",
        default       => "stock-out",
    };
}

// --- PHP: Current year & timestamp ---
$generatedAt = date("d M Y, h:i A");
$year        = date("Y");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="description" content="Electronics Marketplace — PHP-powered product inventory and management table."/>
  <title>Electronics Marketplace — PHP Edition</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: Arial, sans-serif;
      background: #f0f4f8;
      color: #333;
    }

    /* ── PHP Info Bar ── */
    .php-info-bar {
      background: #1d1d2e;
      color: #aaa;
      text-align: center;
      font-size: 12px;
      padding: 7px 10px;
      letter-spacing: 0.4px;
    }
    .php-info-bar span { color: #ff6600; font-weight: bold; }
    .php-badge {
      display: inline-block;
      background: linear-gradient(135deg, #ff6600, #cc3300);
      color: #fff;
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 1px;
      padding: 2px 9px;
      border-radius: 20px;
      margin-left: 6px;
      vertical-align: middle;
    }

    .page-wrap { padding: 30px 20px; }

    h2 {
      text-align: center;
      margin-bottom: 6px;
      font-size: 24px;
      font-weight: bold;
      color: #222;
    }

    .subtitle {
      text-align: center;
      font-size: 13px;
      color: #888;
      margin-bottom: 22px;
    }

    .controls {
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 16px;
    }

    .controls input[type="text"] {
      padding: 8px 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 13px;
      width: 220px;
      outline: none;
    }
    .controls input[type="text"]:focus { border-color: #ff6600; }

    .controls select {
      padding: 8px 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 13px;
      background: white;
      cursor: pointer;
      outline: none;
    }

    .controls button {
      padding: 8px 16px;
      background: #ff6600;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 13px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.2s;
    }
    .controls button:hover { background: #cc5200; }
    .controls button.secondary { background: #0077cc; }
    .controls button.secondary:hover { background: #005fa3; }

    /* Summary Cards */
    .summary {
      display: flex;
      gap: 14px;
      flex-wrap: wrap;
      margin-bottom: 20px;
    }
    .summary-card {
      background: white;
      border-radius: 8px;
      padding: 14px 20px;
      flex: 1;
      min-width: 140px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.08);
      text-align: center;
      border-top: 4px solid #ff6600;
    }
    .summary-card.blue  { border-top-color: #0077cc; }
    .summary-card.green { border-top-color: #28a745; }
    .summary-card.red   { border-top-color: #dc3545; }
    .summary-card.amber { border-top-color: #ff9800; }

    .summary-card .s-val {
      font-size: 22px;
      font-weight: bold;
      color: #222;
    }
    .summary-card .s-label {
      font-size: 12px;
      color: #888;
      margin-top: 3px;
    }
    .php-computed {
      font-size: 10px;
      color: #ccc;
      margin-top: 4px;
      font-style: italic;
    }

    /* Table */
    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    thead tr { background: #ff6600; color: white; }
    thead th {
      padding: 13px 16px;
      font-size: 14px;
      font-weight: bold;
      text-align: center;
      cursor: pointer;
      user-select: none;
      white-space: nowrap;
    }
    thead th:hover { background: #e05a00; }

    tbody tr {
      border-bottom: 1px solid #e8e8e8;
      transition: background 0.15s;
    }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #fff5ee; }
    tbody tr:nth-child(even) { background: #fafafa; }
    tbody tr:nth-child(even):hover { background: #fff0e6; }

    tbody td {
      padding: 11px 16px;
      font-size: 13.5px;
      text-align: center;
      color: #444;
    }

    .badge {
      display: inline-block;
      padding: 3px 10px;
      border-radius: 12px;
      font-size: 11px;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .badge-Mobile      { background: #e3f2fd; color: #0077cc; }
    .badge-Laptop      { background: #f3e5f5; color: #7b1fa2; }
    .badge-Audio       { background: #e8f5e9; color: #2e7d32; }
    .badge-Accessories { background: #fff3e0; color: #e65100; }
    .badge-TV          { background: #fce4ec; color: #c62828; }
    .badge-Camera      { background: #e0f7fa; color: #006064; }

    .stock-in  { color: #28a745; font-weight: bold; }
    .stock-low { color: #ff9800; font-weight: bold; }
    .stock-out { color: #dc3545; font-weight: bold; }

    .price { font-weight: bold; color: #333; }

    .cart-yes { color: #28a745; font-weight: bold; }
    .cart-no  { color: #aaa; }

    .rating { color: #f5a623; font-weight: bold; }

    .no-result {
      text-align: center;
      padding: 24px;
      color: #999;
      font-style: italic;
    }

    .result-info {
      font-size: 12px;
      color: #888;
      margin-bottom: 8px;
    }

    footer {
      text-align: center;
      margin-top: 30px;
      font-size: 12px;
      color: #aaa;
    }
  </style>
</head>
<body>

<!-- ================= PHP INFO BAR ================= -->
<div class="php-info-bar">
  ⚙️ Powered by <span>PHP <?php echo phpversion(); ?></span>
  &nbsp;|&nbsp; Page generated: <span><?php echo $generatedAt; ?></span>
  &nbsp;|&nbsp; <span><?php echo $totalProducts; ?></span> products loaded server-side
</div>

<div class="page-wrap">

  <h2>🛒 Electronics Marketplace <span class="php-badge">PHP</span></h2>
  <p class="subtitle">Product Inventory &amp; Management Table</p>

  <!-- ================= SUMMARY CARDS (PHP-computed) ================= -->
  <div class="summary">
    <div class="summary-card">
      <div class="s-val" id="totalProducts"><?php echo $totalProducts; ?></div>
      <div class="s-label">Total Products</div>
      <div class="php-computed">PHP computed</div>
    </div>
    <div class="summary-card blue">
      <div class="s-val" id="inCartCount"><?php echo $inCartCount; ?></div>
      <div class="s-label">Items in Cart</div>
      <div class="php-computed">PHP computed</div>
    </div>
    <div class="summary-card green">
      <div class="s-val" id="cartTotal">₹<?php echo number_format($cartTotal, 0, '.', ','); ?></div>
      <div class="s-label">Cart Total</div>
      <div class="php-computed">PHP computed</div>
    </div>
    <div class="summary-card red">
      <div class="s-val" id="outOfStock"><?php echo $outOfStock; ?></div>
      <div class="s-label">Out of Stock</div>
      <div class="php-computed">PHP computed</div>
    </div>
    <div class="summary-card amber">
      <div class="s-val" id="lowStock"><?php echo $lowStock; ?></div>
      <div class="s-label">Low Stock</div>
      <div class="php-computed">PHP computed</div>
    </div>
  </div>

  <!-- ================= CONTROLS ================= -->
  <div class="controls">
    <input type="text" id="searchInput" placeholder="🔍 Search product name..." oninput="filterTable()"/>

    <!-- Category filter — options generated by PHP -->
    <select id="categoryFilter" onchange="filterTable()">
      <option value="All">All Categories</option>
      <?php foreach ($categories as $cat): ?>
        <option value="<?php echo htmlspecialchars($cat); ?>"><?php echo htmlspecialchars($cat); ?></option>
      <?php endforeach; ?>
    </select>

    <select id="cartFilter" onchange="filterTable()">
      <option value="All">All Items</option>
      <option value="cart">In Cart Only</option>
      <option value="notcart">Not in Cart</option>
    </select>

    <select id="stockFilter" onchange="filterTable()">
      <option value="All">All Stock</option>
      <option value="In Stock">In Stock</option>
      <option value="Low Stock">Low Stock</option>
      <option value="Out of Stock">Out of Stock</option>
    </select>

    <button onclick="sortByPrice()">Sort by Price</button>
    <button onclick="sortByRating()" class="secondary">Sort by Rating</button>
  </div>

  <div class="result-info" id="resultInfo"></div>

  <!-- ================= TABLE (rows rendered by PHP) ================= -->
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Product Name</th>
        <th>Category</th>
        <th>Price (₹)</th>
        <th>Rating</th>
        <th>Stock</th>
        <th>Brand</th>
        <th>In Cart</th>
      </tr>
    </thead>
    <tbody id="tableBody">
      <?php foreach ($products as $p): ?>
        <tr
          data-name="<?php echo strtolower(htmlspecialchars($p['name'])); ?>"
          data-category="<?php echo htmlspecialchars($p['category']); ?>"
          data-cart="<?php echo $p['inCart'] ? 'true' : 'false'; ?>"
          data-stock="<?php echo htmlspecialchars($p['stock']); ?>"
          data-price="<?php echo $p['price']; ?>"
          data-rating="<?php echo $p['rating']; ?>"
        >
          <td><?php echo $p['id']; ?></td>
          <td><b><?php echo htmlspecialchars($p['name']); ?></b></td>
          <td><span class="badge badge-<?php echo htmlspecialchars($p['category']); ?>"><?php echo htmlspecialchars($p['category']); ?></span></td>
          <td class="price">₹<?php echo number_format($p['price'], 0, '.', ','); ?></td>
          <td class="rating">⭐ <?php echo $p['rating']; ?></td>
          <td class="<?php echo stockClass($p['stock']); ?>"><?php echo htmlspecialchars($p['stock']); ?></td>
          <td><?php echo htmlspecialchars($p['brand']); ?></td>
          <td class="<?php echo $p['inCart'] ? 'cart-yes' : 'cart-no'; ?>"><?php echo $p['inCart'] ? '✔ Yes' : '✘ No'; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <footer>
    &copy; <?php echo $year; ?> Electronics Marketplace — Built with PHP <?php echo phpversion(); ?>
  </footer>
</div>

<script>
  // All rows are already in the DOM (rendered by PHP).
  // JS handles only client-side filtering & sorting.

  let priceSortAsc  = true;
  let ratingSortAsc = false;

  function getRows() {
    return Array.from(document.querySelectorAll("#tableBody tr[data-name]"));
  }

  function filterTable() {
    const search   = document.getElementById("searchInput").value.toLowerCase();
    const category = document.getElementById("categoryFilter").value;
    const cartF    = document.getElementById("cartFilter").value;
    const stockF   = document.getElementById("stockFilter").value;

    let visible = 0;
    getRows().forEach(row => {
      const matchName     = row.dataset.name.includes(search);
      const matchCategory = category === "All" || row.dataset.category === category;
      const matchCart     = cartF === "All"
                              || (cartF === "cart"    && row.dataset.cart === "true")
                              || (cartF === "notcart" && row.dataset.cart === "false");
      const matchStock    = stockF === "All" || row.dataset.stock === stockF;

      const show = matchName && matchCategory && matchCart && matchStock;
      row.style.display = show ? "" : "none";
      if (show) visible++;
    });

    document.getElementById("resultInfo").textContent =
      `Showing ${visible} of ${getRows().length} products`;
  }

  function sortByPrice() {
    const tbody = document.getElementById("tableBody");
    const rows  = getRows();
    rows.sort((a, b) =>
      priceSortAsc
        ? Number(a.dataset.price) - Number(b.dataset.price)
        : Number(b.dataset.price) - Number(a.dataset.price)
    );
    priceSortAsc = !priceSortAsc;
    rows.forEach(r => tbody.appendChild(r));
    filterTable();
  }

  function sortByRating() {
    const tbody = document.getElementById("tableBody");
    const rows  = getRows();
    rows.sort((a, b) =>
      ratingSortAsc
        ? Number(a.dataset.rating) - Number(b.dataset.rating)
        : Number(b.dataset.rating) - Number(a.dataset.rating)
    );
    ratingSortAsc = !ratingSortAsc;
    rows.forEach(r => tbody.appendChild(r));
    filterTable();
  }

  // Init on load
  filterTable();
</script>

</body>
</html>
