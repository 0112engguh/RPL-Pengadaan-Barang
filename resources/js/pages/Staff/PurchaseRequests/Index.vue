<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({ purchaseRequests: Array });

const statusLabel = {
    menunggu_persetujuan: 'Menunggu Persetujuan',
    disetujui: 'Disetujui',
    ditolak: 'Ditolak',
    diproses: 'Diproses',
    po_dibuat: 'PO Dibuat',
    barang_diterima: 'Barang Diterima',
};

const statusColor = {
    menunggu_persetujuan: 'bg-yellow-100 text-yellow-700',
    disetujui: 'bg-green-100 text-green-700',
    ditolak: 'bg-red-100 text-red-700',
    diproses: 'bg-blue-100 text-blue-700',
    po_dibuat: 'bg-blue-100 text-blue-700',
    barang_diterima: 'bg-gray-200 text-gray-700',
};
</script>

<template>
    <div class="min-h-screen bg-gray-50 p-8">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-800">Purchase Request Saya</h1>
            <Link
                href="/staff/purchase-requests/create"
                class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700"
            >
                + Ajukan PR
            </Link>
        </div>

        <div class="overflow-hidden rounded-lg bg-white shadow">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="px-4 py-3">No. PR</th>
                        <th class="px-4 py-3">Alasan</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="pr in purchaseRequests" :key="pr.id" class="border-t">
                        <td class="px-4 py-3 font-medium">{{ pr.pr_number }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ pr.reason }}</td>
                        <td class="px-4 py-3">
                            <span class="rounded-full px-2 py-1 text-xs font-medium" :class="statusColor[pr.status]">
                                {{ statusLabel[pr.status] }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ new Date(pr.created_at).toLocaleDateString('id-ID') }}</td>
                        <td class="px-4 py-3">
                            <Link :href="`/staff/purchase-requests/${pr.id}`" class="text-blue-600 hover:underline">
                                Detail
                            </Link>
                        </td>
                    </tr>
                    <tr v-if="purchaseRequests.length === 0">
                        <td colspan="5" class="px-4 py-6 text-center text-gray-400">Belum ada Purchase Request.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>