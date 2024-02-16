
<template>
    <div v-if="JqxScheduler && jqx">
        <JqxScheduler
            :width="getWidth"
            :height="600"
            :date="date"
            :source="dataAdapter"
            :view="'weekView'"
            :appointmentDataFields="appointmentDataFields"
            :resources="resources"
            :views="views"
        />
    </div>
    <div v-else>
        JqxScheduler or jqx is not defined. Please check your imports.
    </div>
</template>

<script setup>
import { ref } from 'vue';
import JqxScheduler from 'jqwidgets-scripts/jqwidgets-vue/vue_jqxscheduler.vue';
import jqx from 'jqwidgets-scripts';

// rest of your code
</script>