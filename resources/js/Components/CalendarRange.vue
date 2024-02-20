<template>
        <VueDatePicker v-model="dates" :min-date="minDate"
         :enable-time-picker="false" :max-range="30" 
         range="{ maxRange: 30 }" :format="format"/>
</template>

<script setup>
import { ref, watchEffect } from 'vue';
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

const format = (dates) => {
    const start = dates[0];
    const end = dates[1];

    const startDay = start.getDate();
    const startMonth = start.getMonth() + 1;
    const startYear = start.getFullYear();

    const endDay = end.getDate();
    const endMonth = end.getMonth() + 1;
    const endYear = end.getFullYear();

    return `${startDay}/${startMonth}/${startYear} - ${endDay}/${endMonth}/${endYear}`;
};


</script>

<style>
@import '@vuepic/vue-datepicker/dist/main.css';
</style>