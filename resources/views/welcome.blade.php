<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>lightning.utxo.one</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <!-- import alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs"></script>
</head>
<!-- build a minimal ui with a top nav bar and main content area with an orange theme using tailwindcss -->
<body class="bg-orange-100">
    <div id="app">
        <lightning-swap-form></lightning-swap-form>
     </div>
</body>

</html>
