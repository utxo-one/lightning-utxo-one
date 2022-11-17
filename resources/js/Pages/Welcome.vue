<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

const form = useForm({
    amount: '',
    address: '',
    type: '',
});

const submit = () => {
    form.post(route('swap.create'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('amount', 'address');
        },
    });
};
</script>

<template>

    <Head title="Welcome"></Head>

    <!-- create a viewport centered container with an orange theme in tailwind css -->
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <h1 class="text-3xl font-bold text-center text-orange-500 dark:text-white">Lightning Liquidity Swaps</h1>
            <div class="m-5">
                <form @submit.prevent="submit">
                    <input type="hidden" name="swapType" value="ln_to_btc">
                <div class="">
                    <InputLabel for="amount" value="Amount (in sats)" />
                    <TextInput id="amount" type="number" class="mt-1 block w-full" v-model="form.amount" required autofocus
                        autocomplete="amount" />
                    <InputError class="mt-2" :message="form.errors.amount" />
                </div>

                <div class="mt-4">
                    <InputLabel for="address" value="Bitcoin Address" />
                    <TextInput id="address" type="text" class="mt-1 block w-full" v-model="form.address" required
                        autocomplete="address" />
                    <InputError class="mt-2" :message="form.errors.address" />
                </div>

                <div class="flex items-center justify-end mt-4">

                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Swap
                    </PrimaryButton>
                </div>
            </form>
            </div>

        </div>
    </div>
</template>
