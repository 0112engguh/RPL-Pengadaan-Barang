<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({ items: Array });

const form = useForm({
    reason: '',
    items: [{ item_id: '', quantity: 1, note: '' }],
});

function addRow() {
    form.items.push({ item_id: '', quantity: 1, note: '' });
}

function removeRow(index) {
    form.items.splice(index, 1);
}

function submit() {
    form.post('/staff/purchase-requests');
}
</script>

<template>
    <div class="min-h-screen bg-gray-50 p-8">
        <h1 class="mb-6 text-2xl font-semibold text-gray-800">Ajukan Purchase Request</h1>

        <form @submit.prevent="submit" class="max-w-2xl space-y-6 rounded-lg bg-white p-6 shadow">
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Alasan Pengadaan</label>
                <textarea
                    v-model="form.reason"
                    rows="3"
                    required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm"
                ></textarea>
                <p v-if="form.errors.reason" class="mt-1 text-sm text-red-600">{{ form.errors.reason }}</p>
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">Daftar Barang</label>

                <div v-for="(row, index) in form.items" :key="index" class="mb-3 flex items-end gap-2">
                    <div class="flex-1">
                        <select v-model="row.item_id" required class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                            <option value="" disabled>Pilih barang</option>
                            <option v-for="item in items" :key="item.id" :value="item.id">
                                {{ item.name }} ({{ item.unit }})
                            </option>
                        </select>
                    </div>
                    <div class="w-24">
                        <input
                            v-model.number="row.quantity"
                            type="number"
                            min="1"
                            required
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm"
                        />
                    </div>
                    <button
                        v-if="form.items.length > 1"
                        type="button"
                        @click="removeRow(index)"
                        class="rounded-lg border border-gray-300 px-3 py-2 text-sm text-red-600 hover:bg-red-50"
                    >
                        Hapus
                    </button>
                </div>

                <button type="button" @click="addRow" class="text-sm font-medium text-blue-600 hover:underline">
                    + Tambah baris
                </button>
            </div>

            <button
                type="submit"
                :disabled="form.processing"
                class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700 disabled:opacity-50"
            >
                Ajukan
            </button>
        </form>
    </div>
</template>