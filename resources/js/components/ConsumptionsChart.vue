<script setup lang="ts">
import { useFetch } from '@vueuse/core';
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
} from 'chart.js';
import { computed } from 'vue';
import { Bar } from 'vue-chartjs';

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
);

const props = defineProps<{
    contractId: number;
}>();

// Récupération asynchrone des données de consommation pour le contrat spécifique
const { isFetching, data, error } = useFetch(
    `/api/contracts/${props.contractId}/consumptions`,
)
    .get()
    .json();

const chartData = computed(() => {
    if (!data.value) {
        return { labels: [], datasets: [] };
    }

    return {
        labels: data.value.map((item: any) => `Mois ${item.month}`),
        datasets: [
            {
                label: 'Consommation (kWh)',
                backgroundColor: '#3b82f6', // Tailwind blue-500
                borderRadius: 4,
                data: data.value.map((item: any) => item.value),
            },
        ],
    };
});

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: { display: false },
        tooltip: { mode: 'index' as const, intersect: false },
    },
    scales: {
        y: { beginAtZero: true },
    },
};
</script>

<template>
    <div class="h-64 w-full">
        <div v-if="isFetching" class="flex h-full items-center justify-center">
            <div
                class="h-8 w-8 animate-spin rounded-full border-t-2 border-b-2 border-blue-500"
            ></div>
        </div>
        <div v-else-if="error" class="text-red-500">
            Erreur lors du chargement des données.
        </div>
        <div
            v-else-if="data && data.length === 0"
            class="text-sm text-gray-500"
        >
            Aucune donnée de consommation disponible.
        </div>
        <Bar v-else :data="chartData" :options="chartOptions" />
    </div>
</template>
