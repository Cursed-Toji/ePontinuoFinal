<template>

    <table class="w-full divide-y divide-red-400">
        <thead>
            <tr>
                <th class="bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">ATIVIDADES</th>
                <th v-for="user in users" :key="user.id" class="px-11 py-4 bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">{{ user.name }}</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-red-400">
            <tr class="divide-x divide-gray-400">
                <th class="bg-gray-50 w-10 font-medium">Calls</th>
                <td v-for="user in users" :key="user.id" class="text-center py-1">{{ user.calls }}</td>
            </tr>
            <tr class="divide-x divide-gray-400">
                <th class="bg-gray-50 font-medium">Tasks</th>
                <td v-for="user in users" :key="user.id" class="text-center py-1">{{ user.tasks }}</td>
            </tr>
            <tr class="divide-x divide-gray-400">
                <th class="bg-gray-50 font-medium">Imp Um</th>
                <td v-for="user in users" :key="user.id" class="text-center py-1">{{ user.impUm }}</td>
            </tr>
            <tr class="divide-x divide-gray-400">
                <th class="bg-gray-50 font-medium">Imp Dois</th>
                <td v-for="user in users" :key="user.id" class="text-center py-1">{{ user.impDois }}</td>
            </tr>
            <tr class="divide-x divide-gray-400">
                <th class="bg-gray-50 font-medium">Imp Três</th>
                <td v-for="user in users" :key="user.id" class="text-center py-1">{{ user.impTres }}</td>
            </tr>
            <tr class="divide-x divide-gray-400">
                <th class="bg-gray-50 font-medium">Imp Quatro</th>
                <td v-for="user in users" :key="user.id" class="text-center py-1">{{ user.impQuatro }}</td>
            </tr>
            <tr class="divide-x divide-gray-400">
                <th class="bg-gray-50 font-medium">Imp Adicional</th>
                <td v-for="user in users" :key="user.id" class="text-center py-1">{{ user.impAdicional }}</td>
            </tr>
            <tr class="divide-x divide-gray-400">
                <th class="bg-gray-50 font-medium">Imp Gestão</th>
                <td v-for="user in users" :key="user.id" class="text-center py-1">{{ user.impGestao }}</td>
            </tr>
            <tr class="divide-x divide-gray-400">
                <th class="bg-gray-50 font-medium">Imp Komunic</th>
                <td v-for="user in users" :key="user.id" class="text-center py-1">{{ user.impKomunic }}</td>
            </tr>
            <tr class="divide-x divide-gray-400">
                <th class="bg-gray-50 font-medium">Acompanhamentos</th>
                <td v-for="user in users" :key="user.id" class="text-center py-1">{{ user.acompanhamentos }}</td>
            </tr>
            <tr class="divide-x divide-gray-400">
                <th class="bg-gray-50 font-medium">Loja Apple</th>
                <td v-for="user in users" :key="user.id" class="text-center py-1">{{ user.lojaApple }}</td>
            </tr>
            <tr class="divide-x divide-gray-400">
                <th class="bg-gray-50 font-medium">Reagendamentos</th>
                <td v-for="user in users" :key="user.id" class="text-center py-1">{{ user.reagendamentos }}</td>
            </tr>
            <tr class="divide-x divide-gray-400">
                <th class="bg-gray-50 font-medium">Chats</th>
                <td v-for="user in users" :key="user.id" class="text-center py-1">{{ user.chats }}</td>
            </tr>
            <tr class="divide-x divide-gray-400">
                <th class="bg-gray-50 font-medium">Pos-Vendas</th>
                <td v-for="user in users" :key="user.id" class="text-center py-1">{{ user.posVendas }}</td>
            </tr>
            <tr class="divide-x divide-gray-400">
                <th class="bg-gray-50 font-medium">Komunic</th>
                <td v-for="user in users" :key="user.id" class="text-center py-1">{{ user.komunic }}</td>
            </tr>
            <tr class="divide-x divide-gray-400">
                <th class="bg-gray-50 font-medium">Chamados</th>
                <td v-for="user in users" :key="user.id" class="justify-center w-20">
                    <input @input="updatePontuacaoTotal(user, $event.target.value)" type="number" class="text-center">
                </td>
            </tr>
            <tr class="divide-x divide-gray-400">
                <th class="bg-gray-50 font-medium">PONTUAÇÃO TOTAL</th>
                <td v-for="user in users" :key="user.id" class="text-center py-1">{{ user.total }}</td>
            </tr>
        </tbody>
    </table>
    <div class="bg-gray-500">
        <div class="py-9 w-1/6 mx-auto">
            <CalendarRange @update-dates="handleDates"/>
        </div>
    </div>

    <button @click="goToDashboard" type="button" class="w-full flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg gap-x-2 sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700">
		<svg class="w-5 h-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
			<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
		</svg>
		<span>Voltar</span>
	</button>

</template>

<script setup>

// Vue~; 
import { ref, reactive, watchEffect } from 'vue';
import { useForm, router } from '@inertiajs/vue3';

// Calendar~;
import CalendarRange from '@/Components/CalendarRange.vue';



const props = defineProps(['userActivities', 'csrfToken']);

console.log(props.userActivities);

const users = reactive([
    { 
    id: 15129511, 
    name: 'João', 
    calls: 0, 
    tasks: 0,
    impUm: 0,
    impDois: 0,
    impTres: 0,
    impQuatro: 0,
    impAdicional: 0,
    impGestao: 0,
    impKomunic: 0,
    acompanhamentos: 0,
    lojaApple: 0,
    reagendamentos: 0,
    chats: 0,
    posVendas: 0,
    komunic: 0,
    total: 0
    },
    { 
    id: 13711853, 
    name: 'Thomas', 
    calls: 0, 
    tasks: 0, 
    impUm: 0,
    impDois: 0,
    impTres: 0,
    impQuatro: 0,
    impAdicional: 0,
    impGestao: 0,
    impKomunic: 0,
    acompanhamentos: 0,
    lojaApple: 0,
    reagendamentos: 0,
    chats: 0,
    posVendas: 0,
    komunic: 0,
    total: 0
  },
  { 
    id: 14935141, 
    name: 'Felipe', 
    calls: 0, 
    tasks: 0, 
    impUm: 0,
    impDois: 0,
    impTres: 0,
    impQuatro: 0,
    impAdicional: 0,
    impGestao: 0,
    impKomunic: 0,
    acompanhamentos: 0,
    lojaApple: 0,
    reagendamentos: 0,
    chats: 0,
    posVendas: 0,
    komunic: 0,
    total: 0
  },
{
    id: 15441515, 
    name: 'Matheus', 
    calls: 0, 
    tasks: 0, 
    impUm: 0,
    impDois: 0,
    impTres: 0,
    impQuatro: 0,
    impAdicional: 0,
    impGestao: 0,
    impKomunic: 0,
    acompanhamentos: 0,
    lojaApple: 0,
    reagendamentos: 0,
    chats: 0,
    posVendas: 0,
    komunic: 0,
    total: 0
},
{
    id: 15129907, 
    name: 'Luiz', 
    calls: 0, 
    tasks: 0, 
    impUm: 0,
    impDois: 0,
    impTres: 0,
    impQuatro: 0,
    impAdicional: 0,
    impGestao: 0,
    impKomunic: 0,
    acompanhamentos: 0,
    lojaApple: 0,
    reagendamentos: 0,
    chats: 0,
    posVendas: 0,
    komunic: 0,
    total: 0
},
{
    id: 13320209, 
    name: 'Lucas Diego', 
    calls: 0, 
    tasks: 0, 
    impUm: 0,
    impDois: 0,
    impTres: 0,
    impQuatro: 0,
    impAdicional: 0,
    impGestao: 0,
    impKomunic: 0,
    acompanhamentos: 0,
    lojaApple: 0,
    reagendamentos: 0,
    chats: 0,
    posVendas: 0,
    komunic: 0,
    total: 0
},
{
    id: 12907661, 
    name: 'Volnei', 
    calls: 0, 
    tasks: 0, 
    impUm: 0,
    impDois: 0,
    impTres: 0,
    impQuatro: 0,
    impAdicional: 0,
    impGestao: 0,
    impKomunic: 0,
    acompanhamentos: 0,
    lojaApple: 0,
    reagendamentos: 0,
    chats: 0,
    posVendas: 0,
    komunic: 0,
    total: 0,
}
    // Add more users as needed
]);


const updateUserActivities = () => {
    Object.keys(props.userActivities).forEach(userId => {
        const user = users.find(user => user.id == userId);
        if (user) {
            user.calls = props.userActivities[userId]['call'];
            user.tasks = props.userActivities[userId]['task'];
            user.impUm = props.userActivities[userId]['imp_acessorias_etapa_i'];
            user.impDois = props.userActivities[userId]['imp_etapa_ii'];
            user.impTres = props.userActivities[userId]['imp_acessorias_etapa_iii'];
            user.impQuatro = props.userActivities[userId]['imp_acessorias_etapa_iv'];
            user.impAdicional = props.userActivities[userId]['treinamento_adicional'];
            user.impGestao = props.userActivities[userId]['imp_etapa_iii'];
            user.impKomunic = props.userActivities[userId]['imp_komunic_'];
            user.acompanhamentos = props.userActivities[userId]['acompanhamento_'];
            user.lojaApple = props.userActivities[userId]['loja_apple_'];
            user.reagendamentos = props.userActivities[userId]['reagendar'];
            user.chats = props.userActivities[userId]['chat'];
            user.posVendas = props.userActivities[userId]['ps_venda'];
            user.komunic = props.userActivities[userId]['komunic'];


            user.total = (user.calls * 5) + (user.tasks * 25) + (user.impUm * 60) + 
            (user.impDois * 60) + (user.impTres * 60) + (user.impQuatro * 60) + 
            (user.impAdicional * 45) + (user.impGestao * 60) + 
            (user.impKomunic * 50) + (user.acompanhamentos * 5) + 
            (user.lojaApple * 30) + (user.reagendamentos * 5) + (user.chats * 15) + 
            (user.posVendas * 30) + (user.komunic * 5);


            console.log(users.find(user => user.id == userId));
        }
    });
};

updateUserActivities();

const dates = ref([]);


const handleDates = async (newDates) => {
    dates.value = newDates;
    console.log(dates.value);
    const form = useForm({
        startDate: dates.value[0],
        endDate: dates.value[1]
    });

    await form.post('/pontuacao'), {
        onFinish: () => form.reset('startDate', 'endDate'),
    };
};

watchEffect(() => {
    console.log('userActivities changed:', props.userActivities);
    updateUserActivities();
});


function updatePontuacaoTotal(user, pontuacaoChamados) {
    if (Number.isInteger(Number(pontuacaoChamados))) {
        console.log(pontuacaoChamados);
        user.total += Number(pontuacaoChamados) * 10;
    }
}

const goToDashboard = () => {
    router.get('\dashboard');

}

</script>

<style scoped>
@import 'tailwindcss/base';
@import 'tailwindcss/components';
@import 'tailwindcss/utilities';
</style>