<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    name: '',
    email: '',
    gender: '',
    date_of_birth: '',
    job_title: '',
    phone_number: '',
    physical_address: '',
    password: '',
    password_confirmation: '',
});

const currentStep = ref(1);

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

const next = () => {
    if (currentStep.value < 3) {
        currentStep.value++;
    }
};

const prev = () => {
    if (currentStep.value > 1) {
        currentStep.value--;
    }
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <div class="flex justify-center mb-4 mt-6">
            <span class="mr-2 p-6 rounded-full bg-gray-800">
                <svg
                    class="h-8 w-8 text-white"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                    />
                </svg>
            </span>
        </div>
        <div class="flex justify-center">
            <h2 class="mb-4 font-medium text-2xl">Register an account</h2>
        </div>
        <form @submit.prevent="submit" class="max-w-md mx-auto">
            <!-- Step 1 -->
            <div v-if="currentStep === 1">
                <div class="mb-4">
                    <InputLabel for="name" value="Name" />
                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mb-4">
                    <InputLabel for="email" value="Email" />
                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autocomplete="username"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mb-8 flex justify-between">
                    <div class="w-1/2 mr-2">
                        <InputLabel for="gender" value="Gender" />
                        <select
                            id="gender"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            v-model="form.gender"
                        >
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.gender" />
                    </div>

                    <div class="w-1/2 ml-2">
                        <InputLabel for="date_of_birth" value="Date of Birth" />
                        <TextInput
                            id="date_of_birth"
                            type="date"
                            class="mt-1 block w-full"
                            v-model="form.date_of_birth"
                        />
                        <InputError class="mt-2" :message="form.errors.date_of_birth" />
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                    Already have an account?
                </Link>
                    <PrimaryButton class="ms-4" @click.prevent="next">Next</PrimaryButton>
                </div>
            </div>

            <!-- Step 2 -->
            <div v-if="currentStep === 2">
                <div class="mb-4">
                    <InputLabel for="job_title" value="Job Title" />
                    <TextInput
                        id="job_title"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.job_title"
                    />
                    <InputError class="mt-2" :message="form.errors.job_title" />
                </div>

                <div class="mb-4">
                    <InputLabel for="phone_number" value="Phone Number" />
                    <TextInput
                        id="phone_number"
                        type="tel"
                        class="mt-1 block w-full"
                        v-model="form.phone_number"
                    />
                    <InputError class="mt-2" :message="form.errors.phone_number" />
                </div>

                <div class="mb-6">
                    <InputLabel for="physical_address" value="Physical Address" />
                    <textarea
                        id="physical_address"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        v-model="form.physical_address"
                    ></textarea>
                    <InputError class="mt-2" :message="form.errors.physical_address" />
                </div>

                <div class="flex justify-between mt-4">
                    <PrimaryButton @click.prevent="prev">Previous</PrimaryButton>
                    <PrimaryButton @click.prevent="next">Next</PrimaryButton>
                </div>
            </div>

            <!-- Step 3 -->
            <div v-if="currentStep === 3">
                <div class="mb-4">
                    <InputLabel for="password" value="Password" />
                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="mb-6">
                    <InputLabel for="password_confirmation" value="Confirm Password" />
                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                    />
                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>

                <div class="flex justify-between mt-4">
                    <PrimaryButton @click.prevent="prev">Previous</PrimaryButton>
                    <PrimaryButton type="submit" :disabled="form.processing">
                        Register
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>