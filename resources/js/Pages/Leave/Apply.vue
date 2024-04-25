<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import TertiallyButton from '@/Components/TertiallyButton.vue';

const form = useForm({
  type: '',
  start_date: '',
  end_date: '',
  reason: '',
});

function submit() {
    form.post(route('employee-leaves.store'), {
    onSuccess: () => 
    {
        form.reset();
        alert(`Success`);
    },
    onError: (errors) => {
        alert(`Error: ${errors}`);
      console.log('Form errors:', errors);
    },
  });
}
</script>

<template>
  <Head title="Apply for Leave" />
  <AuthenticatedLayout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white border border-gray-300 sm:rounded-lg">
          <section>
            <header>
              <h2 class="text-lg font-medium text-gray-900">Apply for Leave</h2>
            </header>
            <form class="mt-6 space-y-6" @submit.prevent="submit">
              <div class="grid grid-cols-2 gap-6">
                <div>
                  <label for="type" class="block font-medium text-sm text-gray-700">Leave Type</label>
                  <select v-model="form.type" id="type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">
                    <option value="">Select leave type</option>
                    <option value="sick">Sick Leave</option>
                    <option value="vacation">Vacation Leave</option>
                    <option value="personal">Personal Leave</option>
                  </select>
                </div>
                <div>
                  <label for="start_date" class="block font-medium text-sm text-gray-700">Start Date</label>
                  <input type="date" v-model="form.start_date" id="start_date" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" />
                </div>
                <div>
                  <label for="end_date" class="block font-medium text-sm text-gray-700">End Date</label>
                  <input type="date" v-model="form.end_date" id="end_date" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" />
                </div>
                <div>
                  <label for="reason" class="block font-medium text-sm text-gray-700">Reason</label>
                  <textarea v-model="form.reason" id="reason" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1"></textarea>
                </div>
              </div>
              <div class="flex items-center gap-4">
                <button type="submit" class="items-center px-4 py-2 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-sm text-white tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Submit</button>
                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0" leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                  <div v-if="form.errors.length" class="text-red-500">
                    <ul>
                      <li v-for="error in form.errors" :key="error">{{ error }}</li>
                    </ul>
                  </div>
                </Transition>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>