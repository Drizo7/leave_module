<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { CustomerService } from '@/service/Employee';
import { FilterMatchMode, FilterOperator } from 'primevue/api';

const customers = ref();
const selectedCustomers = ref();
const filters = ref();
const representatives = ref([
    { name: 'Amy Elsner', image: 'amyelsner.png' },
    { name: 'Anna Fali', image: 'annafali.png' },
    { name: 'Asiya Javayant', image: 'asiyajavayant.png' },
    { name: 'Bernardo Dominic', image: 'bernardodominic.png' },
    { name: 'Elwin Sharvill', image: 'elwinsharvill.png' },
    { name: 'Ioni Bowcher', image: 'ionibowcher.png' },
    { name: 'Ivan Magalhaes', image: 'ivanmagalhaes.png' },
    { name: 'Onyama Limba', image: 'onyamalimba.png' },
    { name: 'Stephen Shaw', image: 'stephenshaw.png' },
    { name: 'XuXue Feng', image: 'xuxuefeng.png' }
]);
const statuses = ref(['unqualified', 'qualified', 'new', 'negotiation', 'renewal', 'proposal']);

onMounted(() => {
    CustomerService.getCustomersLarge().then((data) => {
        customers.value = getCustomers(data);
    });
});


const initFilters = () => {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
        name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
        'country.name': { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
        representative: { value: null, matchMode: FilterMatchMode.IN },
        date: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.DATE_IS }] },
        balance: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
        status: { operator: FilterOperator.OR, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
        activity: { value: [0, 100], matchMode: FilterMatchMode.BETWEEN },
        verified: { value: null, matchMode: FilterMatchMode.EQUALS }
    };
};

initFilters();

const formatDate = (value) => {
    return value.toLocaleDateString('en-US', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
};
const formatCurrency = (value) => {
    return value.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
};
const clearFilter = () => {
    initFilters();
};
const getCustomers = (data) => {
    return [...(data || [])].map((d) => {
        d.date = new Date(d.date);

        return d;
    });
};
const getSeverity = (status) => {
    switch (status) {
        case 'unqualified':
            return 'danger';

        case 'qualified':
            return 'success';

        case 'new':
            return 'info';

        case 'negotiation':
            return 'warning';

        case 'renewal':
            return null;
    }
};
</script>

<template>
    <Head title="Dashboard" />
    <AdminLayout>
        <div class="py-8">
            <div class="max-w-6xl sm:px-3 lg:px-8">
                <!-- an inner page name -->
                <!-- div class="bg-white border border-gray-300 rounded-lg mb-8 flex justify-between items-center h-8">
                    <span class="ml-8 hover:text-gray-700">Home / {{ $page.props.pageName }}</span>
            </div> -->
                <div class="bg-white border border-gray-300 p-8 rounded-lg mb-4">
                    
                        <div class="flex flex-col gap-6 mb-8 ml-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                            <div class="flex items-center">
                                <div class="w-10 h-24 bg-purple-500 rounded-l-full rounded-r-none rounded-b-full rounded-t-none"></div>
                                <div class="ml-8">
                                <p class="text-lg">Total Employees</p>
                                <p class="text-4xl font-semi-bold">42</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="w-10 h-24 bg-blue-500 rounded-l-full rounded-r-none rounded-b-full rounded-t-none"></div>
                                <div class="ml-8">
                                <p class="text-lg">Departments</p>
                                <p class="text-4xl font-semi-bold">8</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="w-10 h-24 bg-orange-400 rounded-l-full rounded-r-none rounded-b-full rounded-t-none"></div>
                                <div class="ml-8">
                                <p class="text-lg">Leave Types</p>
                                <p class="text-4xl font-semi-bold">3</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="w-10 h-24 bg-yellow-400 rounded-l-full rounded-r-none rounded-b-full rounded-t-none"></div>
                                <div class="ml-8">
                                <p class="text-lg">Pending</p>
                                <p class="text-4xl font-semi-bold">22</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="w-10 h-24 bg-green-600 rounded-l-full rounded-r-none rounded-b-full rounded-t-none"></div>
                                <div class="ml-8">
                                <p class="text-lg">Approved</p>
                                <p class="text-4xl font-semi-bold">15</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="w-10 h-24 bg-red-600 rounded-l-full rounded-r-none rounded-b-full rounded-t-none"></div>
                                <div class="ml-8">
                                <p class="text-lg">Rejected</p>
                                <p class="text-4xl font-semi-bold">5</p>
                                </div>
                            </div>
                            </div>

                        </div>
                        <DataTable v-model:filters="filters" v-model:selection="selectedCustomers" :value="customers" paginator :rows="10" dataKey="id" filterDisplay="menu"
                        :globalFilterFields="['name', 'country.name', 'representative.name', 'balance', 'status']">
                        <template #empty> No customers found. </template>
                        <!-- <Column selectionMode="multiple" headerStyle="width: 3rem"></Column> -->
                        <Column field="name" header="ID" sortable style="min-width: 10rem; font-size: 0.75rem">
                            <template #body="{ data }">
                                {{ data.name }}
                            </template>
                            <template #filter="{ filterModel }">
                                <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by name" />
                            </template>
                        </Column>
                        <Column header="Full Name" sortable sortField="country.name" filterField="country.name" style="min-width: 10rem; font-size: 0.75rem">
                            <template #body="{ data }">
                                <div class="flex items-center gap-2">
                                    <span>{{ data.country.name }}</span>
                                </div>
                            </template>
                            <template #filter="{ filterModel }">
                                <InputText v-model="filterModel.value" type="text" class="p-column-filter" placeholder="Search by country" />
                            </template>
                        </Column>
                        <Column header="Role" sortable sortField="representative.name" filterField="representative" :showFilterMatchModes="false" :filterMenuStyle="{ width: '14rem' }" style="min-width: 10rem ; font-size: 0.75rem">
                            <template #body="{ data }">
                                <div class="flex items-center gap-2">
                                    <span>{{ data.representative.name }}</span>
                                </div>
                            </template>
                            <template #filter="{ filterModel }">
                                <MultiSelect v-model="filterModel.value" :options="representatives" optionLabel="name" placeholder="Any" class="p-column-filter">
                                    <template #option="slotProps">
                                        <div class="flex items-center gap-2">
                                            <span>{{ slotProps.option.name }}</span>
                                        </div>
                                    </template>
                                </MultiSelect>
                            </template>
                        </Column>
                        <Column field="date" header="Date Joined" sortable filterField="date" dataType="date" style="min-width: 8rem; font-size: 0.75rem">
                            <template #body="{ data }">
                                {{ formatDate(data.date) }}
                            </template>
                            <template #filter="{ filterModel }">
                                <Calendar v-model="filterModel.value" dateFormat="mm/dd/yy" placeholder="mm/dd/yyyy" mask="99/99/9999" />
                            </template>
                        </Column>
                        <Column headerStyle="width: 5rem; text-align: center" bodyStyle="text-align: center; overflow: visible">
                            <template #body>
                                <Button type="button" icon="pi pi-cog" rounded />
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
