<template>


	<div>
		<ejs-schedule ref="schedule" width='80%' height='700px' :selectedDate="selectedDate" currentView='Week'
		 :eventSettings="eventSettings" @navigating="onNavigating">
			<e-resources>
				<e-resource field="OwnerId" title="Owner" name="Owners" :dataSource="ownerDataSource" textField="OwnerText"
					idField="Id" colorField="OwnerColor"></e-resource>
			</e-resources>
		</ejs-schedule>	
	
	</div>

	<button @click="goToDashboard" type="button" class="w-full flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg gap-x-2 sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700">
		<svg class="w-5 h-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
			<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
		</svg>
		<span>Voltar</span>
	</button>


  </template>





<script setup>
import { ref, onMounted } from 'vue';
import { provide } from "vue";
import { registerLicense } from '@syncfusion/ej2-base';
registerLicense('Ngo9BigBOggjHTQxAR8/V1NAaF1cXmhIfEx1RHxQdld5ZFRHallYTnNWUj0eQnxTdEFjW35YcXVRQWRdUk1xXw==');
import {
	ScheduleComponent as EjsSchedule, ViewsDirective as EViews, ViewDirective as EView,
	ResourcesDirective as EResources, ResourceDirective as EResource,
	Day, Week, WorkWeek, Month, Agenda, actionComplete
} from "@syncfusion/ej2-vue-schedule";
import { createInertiaApp, router } from '@inertiajs/vue3';

provide('schedule', [Day, Week, WorkWeek, Month, Agenda]);

const props = defineProps(['schedEvents'])



let eventSettings = {
	dataSource: props.schedEvents.map(event => {
		return {
			...event,
			StartTime: new Date(event.StartTime.date),
			EndTime: new Date(event.EndTime.date)
		}
	})
}
console.log(props.schedEvents.map(event => {
	return event.OwnerText
}))

let ownerDataSource = props.schedEvents.map(event => ({
	OwnerText: event.OwnerText,
	Id: event.Id,
	OwnerColor: event.OwnerColor // replace with actual color if available
}))

const schedule = ref(null)

onMounted(() => {
  if (schedule.value) {
    let scheduleComponent = schedule.value.ej2Instances;
    let viewDates = scheduleComponent.getCurrentViewDates();
    console.log(viewDates);
  }
})



const onNavigating = (e) => {
	if (e.action === 'date') {
		setTimeout(() => {
			let scheduleComponent = schedule.value.ej2Instances;
			let viewDates = scheduleComponent.getCurrentViewDates();
			console.log(viewDates);

			let startDate = viewDates[0];
			let endDate = viewDates[6];

			
			const form = useForm({
				startDate: viewDates[0],
				endDate: viewDates[6]
			});

			console.log('Start Date:', startDate);
			console.log('End Date:', endDate);
		}, 0);
	}
}

const goToDashboard = () => {
	router.get('\dashboard');
}


</script>




  
<style>
@import '../../../../node_modules/@syncfusion/ej2-base/styles/material.css';
@import '../../../../node_modules/@syncfusion/ej2-buttons/styles/material.css';
@import '../../../../node_modules/@syncfusion/ej2-calendars/styles/material.css';
@import '../../../../node_modules/@syncfusion/ej2-dropdowns/styles/material.css';
@import '../../../../node_modules/@syncfusion/ej2-inputs/styles/material.css';
@import '../../../../node_modules/@syncfusion/ej2-navigations/styles/material.css';
@import '../../../../node_modules/@syncfusion/ej2-popups/styles/material.css';
@import '../../../../node_modules/@syncfusion/ej2-vue-schedule/styles/material.css';
</style>