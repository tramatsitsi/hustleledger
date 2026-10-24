<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HustleLedger - Log a Sale</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .fnb-orange { background-color: #ff6b00; }
        .fnb-orange-text { color: #ff6b00; }
    </style>
</head>
<body class="bg-gray-100 font-sans text-gray-800 pb-12">

    <nav class="bg-white shadow-sm p-4 mb-6">
        <div class="max-w-md mx-auto flex items-center justify-between">
            <h1 class="text-xl font-bold tracking-tight">Hustle<span class="fnb-orange-text">Ledger</span></h1>
            <span class="text-xs font-semibold bg-gray-200 px-2 py-1 rounded">Youth Entrepreneurship</span>
        </div>
    </nav>

    <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden p-6">
        <h2 class="text-2xl font-bold mb-1">Log a Sale</h2>
        <p class="text-gray-500 text-sm mb-6">Record your daily hustle to build your verified business profile.</p>

        <form action="profile.php" method="POST" class="space-y-4">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Product Sold</label>
                <select name="product" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 p-3 border bg-white">
                    <option value="Car Shampoo 5L">Car Shampoo 5L</option>
                    <option value="Office Degreaser 5L">Office Degreaser 5L</option>
                    <option value="Tyre Shine 1L">Tyre Shine 1L</option>
                    <option value="Household Cleaner 750ml">Household Cleaner 750ml</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                    <input type="number" name="quantity" min="1" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 p-3 border" placeholder="e.g. 5">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Total (ZAR)</label>
                    <input type="number" name="total_price" min="1" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 p-3 border" placeholder="e.g. 250">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Client / Customer Name</label>
                <input type="text" name="client_name" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 p-3 border" placeholder="e.g. Joe's Car Wash">
            </div>

            <button type="submit" class="w-full fnb-orange text-white font-bold py-3 px-4 rounded-lg hover:bg-orange-600 transition duration-150 ease-in-out shadow-lg mt-4">
                Log Sale & Update Profile
            </button>
        </form>
        
        <div class="mt-4 text-center">
            <a href="profile.php" class="text-sm text-gray-500 hover:text-gray-800 underline">View existing profile without logging a sale</a>
        </div>
    </div>

</body>
</html>
