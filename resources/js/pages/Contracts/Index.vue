<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { useFetch } from '@vueuse/core';
import ConsumptionsChart from '@/Components/ConsumptionsChart.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Contrats',
                href: '/contracts',
            },
        ],
    },
});

// Appel API vers la route sécurisée Sanctum
const { isFetching, data: contracts, error } = useFetch('/api/contracts').get().json();

// Fonction locale de formatage monétaire
const formatCurrency = (value: number) => {
    return new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(value);
};
</script>

<template>
    <Head title="Mes Contrats" />

    <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4 md:p-6 bg-gray-50/50 dark:bg-transparent">
        
        <div class="flex items-center justify-between mb-2">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">Aperçu de vos contrats</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Consultez et analysez vos différents contrats d'énergies actifs.</p>
            </div>
        </div>

        <!-- Chargement -->
        <div v-if="isFetching" class="flex flex-col items-center justify-center p-12">
             <div class="h-10 w-10 animate-spin flex-shrink-0 rounded-full border-b-2 border-t-2 border-primary"></div>
             <p class="mt-4 text-sm text-gray-500">Chargement de vos contrats...</p>
        </div>

        <!-- Erreur -->
        <div v-else-if="error" class="rounded-xl bg-red-50 p-4 border border-red-200 dark:bg-red-900/20 dark:border-red-800">
            <div class="flex">
                <p class="text-sm font-medium text-red-800 dark:text-red-200">
                    Nous n'avons pas pu charger vos contrats. Vérifiez votre connexion.
                </p>
            </div>
        </div>

        <!-- Vide -->
        <div v-else-if="contracts && contracts.data && contracts.data.length === 0" class="flex flex-col items-center justify-center p-12 border-2 border-dashed rounded-xl border-gray-200 dark:border-sidebar-border">
            <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-white">Aucun contrat</h3>
            <p class="mt-1 text-sm text-gray-500 text-center max-w-sm">Vous n'avez pas encore de contrat actif enregistré sur la plateforme Espace Client Éco.</p>
        </div>

        <!-- Liste des contrats -->
        <div v-else class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            <div 
                v-for="contract in contracts.data" 
                :key="contract.id"
                class="group flex flex-col overflow-hidden rounded-2xl border border-gray-200/60 bg-white shadow-sm transition-all hover:shadow-md dark:border-sidebar-border dark:bg-[#1a1c23] hover:-translate-y-1"
            >
                <!-- En-tête de Carte -->
                <div class="border-b border-gray-100 px-6 py-5 dark:border-white/5">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20 dark:bg-green-500/10 dark:text-green-400 dark:ring-green-500/20">
                                Actif
                            </span>
                            <h3 class="mt-2 text-lg font-semibold text-gray-900 dark:text-white">
                                Référence : {{ contract.reference }}
                            </h3>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Montant estimé</p>
                            <p class="mt-1 text-2xl font-bold tracking-tight text-blue-600 dark:text-blue-400">
                                {{ formatCurrency(contract.amount) }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="mt-4 flex gap-6 text-sm text-gray-500 dark:text-gray-400">
                        <div class="flex items-center gap-1.5">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                            Début : {{ contract.start_date || 'N/A' }}
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                            Fin : {{ contract.end_date || 'N/A' }}
                        </div>
                    </div>
                </div>

                <!-- Corps du Graphique -->
                <div class="p-6">
                    <h4 class="mb-4 text-sm font-medium text-gray-900 dark:text-gray-200">Évolution des consommations</h4>
                    <ConsumptionsChart :contract-id="contract.id" />
                </div>
            </div>
        </div>

    </div>
</template>
