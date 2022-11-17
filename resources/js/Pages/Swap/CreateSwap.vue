<script setup>
import { usePage } from '@inertiajs/inertia-vue3';

const props = usePage().props.value;

//transform amount and fee to number formatted string
const amount = props.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
const fee = props.fee.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
const total = (props.fee + props.amount).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

var imgSrc = 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' + props.paymentRequest;

// every 2 seconds, checkInvoiceStatus
setInterval(() => {
    axios.get('/api/ln-to-btc/' + props.swapUuid).then(check => {
        // if the response contains a string that is longer than 5 characters, it is a txid
        if (check.data.length > 5) {
            // redirect to the show page
            window.location.href = '/swap/show/' + props.swapUuid;
        }
    });
}, 2000);

</script>

<template>

    <Head title="Welcome"></Head>

    <!-- create a viewport centered container with an orange theme in tailwind css -->
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md sm:rounded-lg">
            <h1 class="text-3xl font-bold text-center text-orange-500 dark:text-white">Send Payment</h1>
            <div class="m-5">
                <div class="text-center text-gray-600 text-sm break-words">
                    <span class="font-bold">Swap ID:</span> {{ props.swapUuid }}
                </div>
                <div class="text-center text-orange-500 text-md mt-3 font-bold">
                    Fee: {{ fee }} sats
                </div>
                <!-- if txid is not null, replace this img with a different image-->
                <img class="mx-auto mt-5" :src="imgSrc"/>

                <div class="text-center text-gray-600 text-sm break-words">
                    {{ props.paymentRequest }}
                </div>
                <hr class="m-4">
                <div class="text-center mt-4 text-sm text-gray-500">
                    We will send <span class="font-bold text-orange-500">{{ amount }}</span> sats to
                    <a :href="'https://mempool.space/testnet/address/' + props.address" target="_blank"
                        class="text-blue-500 underline"> {{ props.address }}</a>
                </div>

            </div>

        </div>
    </div>
</template>