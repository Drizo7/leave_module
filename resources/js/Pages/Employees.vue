<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { CustomerService } from '@/service/Employee';
import { FilterMatchMode, FilterOperator } from 'primevue/api';

/* const navigateToRoute = () => {
  window.location.href = '/profile'; // Replace with the actual route URL
}; */

const customers = ref();
const selectedCustomers = ref();
const filters = ref();
const representatives = ref([
    { name: 'Amy Elsner', image: 'amyelsner.png' }
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
    <Head title="Employees" />
    <AuthenticatedLayout>
        <div class="py-4">
            <div class="max-w-6xl sm:px-3 lg:px-8">
                <div class="flex justify-end mb-4"><PrimaryButton :href="route('employeeform')">Add New Employee</PrimaryButton></div>
                <div class="bg-white border border-gray-300 p-8 rounded-lg mb-4">
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
                                            \<span>{{ slotProps.option.name }}</span>
                                        </div>
                                    </template>
                                </MultiSelect>
                            </template>
                        </Column>
                        <Column field="balance" header="Salary" sortable filterField="balance" dataType="numeric" style="min-width: 10rem; font-size: 0.75rem">
                            <template #body="{ data }">
                                {{ formatCurrency(data.balance) }}
                            </template>
                            <template #filter="{ filterModel }">
                                <InputNumber v-model="filterModel.value" mode="currency" currency="USD" locale="en-US" />
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
                        <Column header="Status" field="status" sortable :filterMenuStyle="{ width: '14rem' }" style="min-width: 10rem; font-size: 0.75rem">
                            <template #body="{ data }">
                                <Tag :value="data.status" :severity="getSeverity(data.status)" />
                            </template>
                            <template #filter="{ filterModel }">
                                <Dropdown v-model="filterModel.value" :options="statuses" placeholder="Select One" class="p-column-filter" showClear>
                                    <template #option="slotProps">
                                        <Tag :value="slotProps.option" :severity="getSeverity(slotProps.option)" />
                                    </template>
                                </Dropdown>
                            </template>
                        </Column>
                        <Column field="activity" header="Leave Type" sortable :showFilterMatchModes="false" style="min-width: 10rem; font-size: 0.75rem">
                            <template #body="{ data }">
                                <ProgressBar :value="data.activity" :showValue="false" style="height: 6px"></ProgressBar>
                            </template>
                            <template #filter="{ filterModel }">
                                <Slider v-model="filterModel.value" range class="m-3"></Slider>
                                <div class="flex items-center justify-between px-2">
                                    <span>{{ filterModel.value ? filterModel.value[0] : 0 }}</span>
                                    <span>{{ filterModel.value ? filterModel.value[1] : 100 }}</span>
                                </div>
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
    </AuthenticatedLayout>
</template>
