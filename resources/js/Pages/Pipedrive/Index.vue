<template>
    <div class="min-w-1/2 mx-auto text-center">
        <table class="w-full">
            <thead>
                <tr>
                    <th></th>
                    <th>Segunda-feira</th>
                    <th>Terça-feira</th>
                    <th>Quarta-feira</th>
                    <th>Quinta-feira</th>
                    <th>Sexta-feira</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(time, timeIndex) in times" :key="time">
                    <td class="py-4">{{ time }}</td>
                    <td class="py-4" v-for="day in days" :key="day">
                    {{ weekData[day][treinamentos[timeIndex]] }}</td>
                </tr>
            </tbody>
        </table>
        <input type="date" v-model="selectedDate" @change="onDateChange" class="mt-10">

    </div>
</template>

<script setup>
import { ref } from 'vue';


const props = defineProps(['weekData']);

const days = ref([
    'Monday', 
    'Tuesday', 
    'Wednesday', 
    'Thursday', 
    'Friday']);
    
const times = ref([
    '09h', 
    '10h', 
    '14h', 
    '16h']);
    
const treinamentos = ['treinamento_um', 'treinamento_dois', 'treinamento_tres', 'treinamento_quatro'];

// Add a ref for the selected date
const selectedDate = ref('');

// Validate the selected date and emit an event
const onDateChange = async () => {
    const date = new Date(selectedDate.value);
    
    // Check if the selected date is a Monday
    if (date.getDay() === 0) {
        // Calculate the date of the next Saturday
        const nextSaturday = new Date(date);
        nextSaturday.setDate(date.getDate() + 5);

        // Format the dates as 'yyyy-mm-dd'
        const mondayDate = date.toISOString().split('T')[0];
        const saturdayDate = nextSaturday.toISOString().split('T')[0];

        // Send a POST request to your PHP controller with the selected dates as the payload
        const response = await fetch('http://127.0.0.1:8000/pipedrive', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ monday: mondayDate, saturday: saturdayDate })
        });

        // Handle the response
        if (response.ok) {
            const data = await response.json();
            console.log("deu certo acho")
            // Do something with the data

        } else {
            console.error('Error:', response.status, response.statusText);
        }
    } else {
        alert('Por favor, selecione uma segunda-feira!');
        selectedDate.value = '';
    }
};

</script>