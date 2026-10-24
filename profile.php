<?php
// Include the database connection
require 'db.php';

// 1. Handle form submission (Log a new sale)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product = htmlspecialchars($_POST['product'] ?? '');
    $qty = (int)($_POST['quantity'] ?? 0);
    $price = (float)($_POST['total_price'] ?? 0);
    $client = htmlspecialchars($_POST['client_name'] ?? '');

    // Insert into the database using Prepared Statements (Security!)
    $stmt = $pdo->prepare("INSERT INTO sales (product, quantity, total_price, client_name) VALUES (?, ?, ?, ?)");
    $stmt->execute([$product, $qty, $price, $client]);

    // Redirect to prevent form resubmission on refresh
    header('Location: profile.php');
    exit;
}

// 2. Fetch Totals from the Database
$stmt = $pdo->query("SELECT SUM(total_price) as revenue, SUM(quantity) as units, COUNT(id) as clients FROM sales");
$totals = $stmt->fetch(PDO::FETCH_ASSOC);

$totalRevenue = $totals['revenue'] ?? 0;
$totalUnits = $totals['units'] ?? 0;
$salesCount = $totals['clients'] ?? 0;

// 3. Fetch the Recent Sales List
$stmt = $pdo->query("SELECT * FROM sales ORDER BY created_at DESC LIMIT 10");
$recentSales = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HustleLedger - Verified Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .fnb-orange-text { color: #ff6b00; }
        .verified-badge { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    </style>
</head>
<body class="bg-gray-100 font-sans text-gray-800 pb-12">

    <nav class="bg-white shadow-sm p-4 mb-6">
        <div class="max-w-md mx-auto flex items-center justify-between">
            <h1 class="text-xl font-bold tracking-tight">Hustle<span class="fnb-orange-text">Ledger</span></h1>
            <a href="index.php" class="text-sm font-semibold text-orange-600 hover:text-orange-800">&larr; Log New Sale</a>
        </div>
    </nav>

    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6">
            <div class="bg-gray-900 p-6 text-center text-white relative">
                <div class="w-20 h-20 bg-gray-700 rounded-full mx-auto mb-3 flex items-center justify-center border-4 border-gray-800 text-3xl">
                    🧴
                </div>
                <h2 class="text-2xl font-bold">Your Cleaning Biz</h2>
                <p class="text-gray-400 text-sm">Township Micro-Supplier</p>
                
                <div id="verification-badge" class="absolute top-4 right-4 hidden verified-badge text-white text-xs font-bold px-3 py-1 rounded-full shadow flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Verified
                </div>
            </div>

            <div class="grid grid-cols-3 divide-x divide-gray-200 border-b border-gray-200 text-center p-4">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Revenue</p>
                    <p class="text-lg font-bold text-gray-900">R <?php echo number_format($totalRevenue, 2); ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Units Sold</p>
                    <p class="text-lg font-bold text-gray-900"><?php echo $totalUnits; ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Clients</p>
                    <p class="text-lg font-bold text-gray-900"><?php echo $salesCount; ?></p>
                </div>
            </div>

            <div class="p-6">
                <button onclick="simulateVerification()" id="verify-btn" class="w-full bg-gray-100 border border-gray-300 text-gray-700 font-semibold py-3 px-4 rounded-lg hover:bg-gray-200 transition duration-150 ease-in-out">
                    Verify Latest Client via WhatsApp
                </button>
            </div>
        </div>

        <h3 class="text-lg font-bold mb-3 px-2">Transaction History (Latest 10)</h3>
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <ul class="divide-y divide-gray-200">
                <?php if (empty($recentSales)): ?>
                    <li class="p-6 text-center text-gray-500 text-sm">No sales logged yet.</li>
                <?php else: ?>
                    <?php foreach ($recentSales as $sale): ?>
                        <li class="p-4 flex justify-between items-center">
                            <div>
                                <p class="font-semibold text-sm"><?php echo $sale['product']; ?> (x<?php echo $sale['quantity']; ?>)</p>
                                <p class="text-xs text-gray-500"><?php echo $sale['client_name']; ?> &middot; <?php echo date('Y-m-d H:i', strtotime($sale['created_at'])); ?></p>
                            </div>
                            <span class="font-bold text-green-600 text-sm">+ R<?php echo number_format($sale['total_price'], 2); ?></span>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <script>
        function simulateVerification() {
            const btn = document.getElementById('verify-btn');
            const badge = document.getElementById('verification-badge');
            
            btn.innerText = "Sending WhatsApp message...";
            btn.classList.add('opacity-50', 'cursor-not-allowed');

            setTimeout(() => {
                btn.classList.add('hidden');
                badge.classList.remove('hidden');
                
                badge.classList.add('animate-bounce');
                setTimeout(() => badge.classList.remove('animate-bounce'), 1000);
                
                alert("Simulation: Client replied 'YES' on WhatsApp. Business verified!");
            }, 2000);
        }
    </script>
</body>
</html>
