<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Items</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="container mx-auto mt-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Return Items</h2>
            <form action="process_return.php" method="POST">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="product_name" class="block text-gray-600 font-medium mb-2">Product Name</label>
                        <input type="text" id="product_name" name="product_name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter product name" required>
                    </div>
                    <div>
                        <label for="return_reason" class="block text-gray-600 font-medium mb-2">Reason for Return</label>
                        <input type="text" id="return_reason" name="return_reason" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter reason for return" required>
                    </div>
                </div>
                <div class="mt-4">
                    <label for="additional_notes" class="block text-gray-600 font-medium mb-2">Additional Notes</label>
                    <textarea id="additional_notes" name="additional_notes" rows="4" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter any additional notes"></textarea>
                </div>
                <button type="submit" class="mt-4 bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition duration-300">Submit Return</button>
            </form>
        </div>
    </div>
</body>
</html>