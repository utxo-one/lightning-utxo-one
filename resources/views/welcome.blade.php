<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>lightning.utxo.one</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- import alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs"></script>
</head>
<!-- build a minimal ui with a top nav bar and main content area with an orange theme using tailwindcss -->
<body class="bg-orange-100">
    <nav class="bg-orange-500 p-4">
        <div class="container mx-auto">
            <div class="flex items center">
                <div class="flex-1">
                    <a href="/" class="text-white text-2xl">lightning.utxo.one</a>
                </div>
                <!-- increase space between each menu item and add a hover effect -->
                <div class="flex-1 text-right space-x-6">
                    <a href="/ln2btc" class="text-white text-md font-bold ">Lightning to Bitcoin</a>
                    <a href="/btc2ln" class="text-white text-md font-bold">Bitcoin to Lightning</a>
                    <a href="/balanced-channel" class="text-white text-md font-bold">Balanced Channel</a>
                    <a href="/inbound-liquidity" class="text-white text-md font-bold">Inbound Liquidity</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container mx-auto p-4">
        <div class="bg-white p-4 rounded shadow">
            <!-- build a small form interface to accept a lightning invoice and an on-chain address. The heading should read "Lightning to Bitcoin". should be centered with large text and padding -->
            <h1 class="text-3xl text-center p-4">Lightning to Bitcoin</h1>
            <div class="flex justify-center">
                <div class="w-1/2">
                    <form action="/ln2btc" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="satAmount" class="block text-gray-700 text-sm font-bold mb-2">Sats to Swap</label>
                            <input placeholder="100,000 sats minimum" type="text" name="satAmount" id="satAmount" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label for="onchain_address" class="block text-gray-700 text-sm font-bold mb-2">On-Chain Address</label>
                            <input type="text" name="onchain_address" id="onchain_address" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="flex items center justify-between">
                            <button class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
        </div>            
    </div>
</body>

</html>
