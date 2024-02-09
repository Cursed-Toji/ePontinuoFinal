<template>
    <div class="flex flex-col">
        <div v-for="(user, index) in users" :key="index" class="mb-4">
            <label :for="'user-' + index" class="block text-sm font-medium text-gray-700">
                {{ user.name }}
            </label>
            <input
                :id="'user-' + index"
                v-model.number="user.chamados"
                @input="updatePontuacaoTotal(user)"
                type="number"
                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >
        </div>
    </div>
</template>

<script setup>
import { ref, reactive } from 'vue';

const users = reactive([
    // your users data here
]);

const pontuacaoTotal = ref(0);

const updatePontuacaoTotal = (user) => {
    if (Number.isInteger(user.chamados)) {
        pontuacaoTotal.value += user.chamados * 10;
    }
};
</script>

<style scoped>
/* Add your Tailwind CSS styles here */
</style>

<style scoped>
/* Add your Tailwind CSS styles here */
</style>