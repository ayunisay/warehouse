<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Transaction History</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="container mx-auto mt-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Daily Transaction History</h2>
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Transaction ID</th>
                        <th class="py-2 px-4 border-b">Date</th>
                        <th class="py-2 px-4 border-b">Customer</th>
                        <th class="py-2 px-4 border-b">Total Amount</th>
                        <th class="py-2 px-4 border-b">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Contoh data transaksi harian
                    $transactions = [
                        ['id' => 'TRX001', 'date' => '2025-04-01', 'customer' => 'John Doe', 'amount' => '$500', 'status' => 'Completed'],
                        ['id' => 'TRX002', 'date' => '2025-04-01', 'customer' => 'Jane Smith', 'amount' => '$300', 'status' => 'Pending'],
                    ];

                    if (!empty($transactions)) {
                        foreach ($transactions as $transaction) {
                            echo "<tr>
                                    <td class='py-2 px-4 border-b'>{$transaction['id']}</td>
                                    <td class='py-2 px-4 border-b'>{$transaction['date']}</td>
                                    <td class='py-2 px-4 border-b'>{$transaction['customer']}</td>
                                    <td class='py-2 px-4 border-b'>{$transaction['amount']}</td>
                                    <td class='py-2 px-4 border-b'>{$transaction['status']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr>
                                <td colspan='5' class='py-2 px-4 border-b text-center text-gray-500'>No transactions found.</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>