<script setup>
defineProps({ purchaseRequest: Object });
</script>

<template>
    <div class="min-h-screen bg-gray-50 p-8">
        <h1 class="mb-1 text-2xl font-semibold text-gray-800">{{ purchaseRequest.pr_number }}</h1>
        <p class="mb-6 text-sm text-gray-500">Status: {{ purchaseRequest.status }}</p>

        <div class="max-w-2xl rounded-lg bg-white p-6 shadow">
            <p class="mb-4 text-sm text-gray-700"><strong>Alasan:</strong> {{ purchaseRequest.reason }}</p>

            <table class="w-full text-left text-sm">
                <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="px-3 py-2">Barang</th>
                        <th class="px-3 py-2">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in purchaseRequest.items" :key="row.id" class="border-t">
                        <td class="px-3 py-2">{{ row.item.name }}</td>
                        <td class="px-3 py-2">{{ row.quantity }} {{ row.item.unit }}</td>
                    </tr>
                </tbody>
            </table>

            <p v-if="purchaseRequest.approval_note" class="mt-4 rounded-lg bg-gray-50 p-3 text-sm text-gray-600">
                <strong>Catatan Approver:</strong> {{ purchaseRequest.approval_note }}
            </p>
        </div>
    </div>
</template>