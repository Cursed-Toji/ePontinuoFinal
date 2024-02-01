<template>
        <VueDatePicker v-model="dates" :min-date="minDate" :enable-time-picker="false" range/>
</template>

<script setup>
import { ref, watchEffect, defineEmits } from 'vue';
import VueDatePicker from '@vuepic/vue-datepicker';

const emits = defineEmits(['update-dates']);
const dates = ref();
const minDate = new Date('2023-12-26');

watchEffect(() => {
    if (dates.value && dates.value.length === 2) {
        const [startDate, endDate] = dates.value;

        const formattedStartDate = `${startDate.getFullYear()}-${String(startDate.getMonth() + 1).padStart(2, '0')}-${String(startDate.getDate()).padStart(2, '0')}`;
        const formattedEndDate = `${endDate.getFullYear()}-${String(endDate.getMonth() + 1).padStart(2, '0')}-${String(endDate.getDate()).padStart(2, '0')}`;

        emits('update-dates', [formattedStartDate, formattedEndDate]);
    }
});
</script>

<style>
@import '@vuepic/vue-datepicker/dist/main.css';
</style>