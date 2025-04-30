<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Invoice</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="container mx-auto mt-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Create Invoice</h2>
            <form action="process_invoice.php" method="POST">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="customer_name" class="block text-gray-600 font-medium mb-2">Customer Name</label>
                        <input type="text" id="customer_name" name="customer_name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter customer name" required>
                    </div>
                    <div>
                        <label for="invoice_date" class="block text-gray-600 font-medium mb-2">Invoice Date</label>
                        <input type="date" id="invoice_date" name="invoice_date" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                </div>
                <div class="mt-4">
                    <label for="product_details" class="block text-gray-600 font-medium mb-2">Product Details</label>
                    <textarea id="product_details" name="product_details" rows="4" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter product details (e.g., product name, quantity, price)" required></textarea>
                </div>
                <button type="submit" class="mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">Generate Invoice</button>
            </form>
        </div>
    </div>
</body>
</html>