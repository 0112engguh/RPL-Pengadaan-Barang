<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen bg-gray-50 p-8">
        <h1 class="text-2xl font-semibold text-gray-800">Dashboard Staff / Unit Kerja</h1>
        <p class="mt-1 text-sm text-gray-500">Kelola Purchase Request Anda di sini.</p>

        <div class="mt-6 flex gap-3">
            <Link
                href="/staff/purchase-requests/create"
                class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white transition hover:bg-blue-700"
            >
                Ajukan Purchase Request
            </Link>
            <Link
                href="/staff/purchase-requests"
                class="rounded-lg border border-gray-300 px-4 py-2 font-medium text-gray-700 transition hover:bg-gray-50"
            >
                Lihat Semua PR
            </Link>
        </div>
    </div>
</template>