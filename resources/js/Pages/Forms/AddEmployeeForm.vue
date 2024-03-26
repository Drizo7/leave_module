<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';


</script>

<template>
    <Head title="Add Employee" />

    <AuthenticatedLayout>
        
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Update Password</h2>

                            <p class="mt-1 text-sm text-gray-600">
                                Ensure your account is using a long, random password to stay secure.
                            </p>
                        </header>

                        <form class="mt-6 space-y-6">
                            <div>
                                <InputLabel for="current_password" value="Current Password" />

                                <TextInput
                                    id="current_password"
                                    ref="currentPasswordInput"
                                    type="password"
                                    class="mt-1 block w-full"
                                    autocomplete="current-password"
                                />

                                
                            </div>

                            <div>
                                <InputLabel for="password" value="New Password" />

                                <TextInput
                                    id="password"
                                    ref="passwordInput"
                                    type="password"
                                    class="mt-1 block w-full"
                                    autocomplete="new-password"
                                />

                            
                            </div>

                            <div>
                                <InputLabel for="password_confirmation" value="Confirm Password" />

                                <TextInput
                                    id="password_confirmation"
                                    type="password"
                                    class="mt-1 block w-full"
                                    autocomplete="new-password"
                                />

                                
                            </div>

                            <div class="flex items-center gap-4">
                                <PrimaryButton >Save</PrimaryButton>

                                <Transition
                                    enter-active-class="transition ease-in-out"
                                    enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out"
                                    leave-to-class="opacity-0"
                                >
                                    
                                </Transition>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>