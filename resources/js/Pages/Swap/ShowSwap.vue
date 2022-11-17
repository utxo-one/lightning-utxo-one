<script setup>
import { usePage } from '@inertiajs/inertia-vue3';
import successImg from '../../../img/success.gif';

const props = usePage().props.value;

// format amount to number format with numbers string
const amount = props.swap.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

</script>

<template>

    <Head title="Welcome"></Head>

    <!-- create a viewport centered container with an orange theme in tailwind css -->
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md sm:rounded-lg">
            <h1 class="text-3xl font-bold text-center text-green-600 dark:text-white">Success!</h1>
            <div class="m-5">
                <div class="text-center text-gray-600 text-sm break-words">
                    <span class="font-bold">Transaction:</span> <a :href="'https://mempool.space/testnet/tx/' + props.swap.txid" target="_blank" class="text-blue-500 underline">{{ props.swap.txid }} </a>
                </div>
                <!-- if txid is not null, replace this img with a different image-->
                <img class="mx-auto mt-5" :src="successImg">

                <hr class="m-4">
                <div class="text-center mt-4 text-sm text-gray-500">
                    We sent <span class="font-bold text-orange-500">{{ amount }}</span> sats to
                    <a :href="'https://mempool.space/testnet/address/' + props.swap.address" target="_blank"
                        class="text-blue-500 underline"> {{ props.swap.address }}</a>.
                        
                </div>


            </div>

        </div>
    </div>
</template>