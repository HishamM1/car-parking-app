<template>
    <form @submit.prevent="store.handleSubmit" novalidate>
    <div class=" flex flex-col mx-auto md:w-96 w-full">
        <h1 class=" text-2xl font-bold mb-4 text-center">Register</h1>
        <!-- Name -->
        <div class="flex flex-col gap-2 mb-4">
            <label for="name" class="required">Name</label>
            <input v-model="store.form.name" id="name" name="name" type="text" class="form-input" autocomplete="name" :disabled="store.loading" required>
            <ValidationError :errors="store.errors" field="name" />
        </div>
        <!-- Email -->
        <div class="flex flex-col gap-2 mb-4">
            <label for="email" class="required">Email</label>
            <input v-model="store.form.email" id="email" name="email" type="email" class="form-input" autocomplete="email" :disabled="store.loading" required>
            <ValidationError :errors="store.errors" field="email" />
        </div>
        <!-- Password -->
        <div class="flex flex-col gap-2 mb-4">
            <label for="password" class=" required">Password</label>
            <input v-model="store.form.password" id="password" name="password" type="password" class="form-input" autocomplete="new-password" :disabled="store.loading" required>
            <ValidationError :errors="store.errors" field="password" />
        </div>
        <!-- Confirm Password -->
        <div class="flex flex-col gap-2 mb-4">
            <label for="password_confirmation" class=" required">Confirm Password</label>
            <input v-model="store.form.password_confirmation" id="password_confirmation" name="password_confirmation" type="password" class="form-input" autocomplete="new-password" :disabled="store.loading" required>
        </div>

        <div class="border-t h-[1px] my-6"></div>

        <div class="flex flex-col gap-2">
            <button type="submit" class="btn btn-primary" :disabled="store.loading">
            <IconSpinner v-show="store.loading" />
            Register
            </button>
        </div>


    </div>
    </form>
</template>

<script setup>
import { onBeforeUnmount } from 'vue';
import { useRegister } from '@/stores/register.js'
import ValidationError from '@/components/ValidationError.vue';
import IconSpinner from "@/components/IconSpinner.vue";

const store = useRegister();

onBeforeUnmount(store.resetForm);
</script>
