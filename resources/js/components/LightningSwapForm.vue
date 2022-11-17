<template>
    <!-- Create a form using tailwindcss in an orange theme that asks for an amount in satoshis and a bitcoin address -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Lightning Swap</div>

                    <div class="card-body">
                        <form class="bg-orange-100 shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="submit">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="amount">
                                    Amount (satoshis)
                                </label>
                                <input
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="amount" type="number" placeholder="Amount" v-model="amount">
                            </div>
                            <div class="mb-6">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="address">
                                    Bitcoin Address
                                </label>
                                <input
                                    class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                                    id="address" type="text" placeholder="Bitcoin Address" v-model="address">
                                <p class="text-red-500 text-xs italic" v-if="errors.address">Please choose a bitcoin
                                    address.</p>
                            </div>
                            <div class="flex items center justify-between">
                                <button
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                    type="submit">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- display the json response in a card-->
                    <div class="card-body" v-if="response">
                        <div class="card">
                            <div class="card-header">Response</div>
                            <div class="card-body">
                                <img :src="'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' + response.payment_request"
                                    alt="qr code">
                                <pre>{{ response.payment_request }}</pre>

                                <!-- display the invoice status in a card -->
                                <div class="card-body" v-if="txid">
                                    <div class="card">
                                        <div class="card-header">Transaction</div>
                                        <div class="card-body">
                                            <!-- display a link to the mempool https://mempool.space/testnet/tx/{txid}} that opens in a new tab-->
                                            <a :href="'https://mempool.space/testnet/tx/' + txid" target="_blank">{{
                                                    txid
                                            }}</a>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            amount: null,
            address: null,
            errors: {},
            response: null,
            txid: null,
            timer: null,
        }
    },

    methods: {
        submit() {

            this.errors = {}
            if (!this.address) {
                this.errors.address = true
            }
            if (Object.keys(this.errors).length) {
                return
            }
            axios.post('/api/ln-to-btc', {
                amount: this.amount,
                addr: this.address
            }).then(response => {
                this.response = response.data
            });

            this.timer = setInterval(() => {
                this.checkInvoiceStatus(this.response.uuid)
            }, 3000);
        },

        checkInvoiceStatus(uuid) {
            axios.get('/api/ln-to-btc/' + uuid).then(check => {
                // if the response contains a string that is longer than 5 characters, it is a txid
                if (check.data.length > 5) {
                    this.txid = check.data;
                    clearInterval(this.timer);                                
                }
            })

        },

        beforeDestroy() {
            clearInterval(this.timer)
        }
    }
}
</script>


