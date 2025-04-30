<template>
    <div>
        <div v-if="latitude !== null && longitude !== null">
            <p>Latitude: {{ latitude }}</p>
            <p>Longitude: {{ longitude }}</p>
        </div>

        <p v-if="error">{{ error }}</p>
    </div>

    <form @submit.prevent="submit" class="space-y-4">
        <div>
            <label for="name" class="block">Name:</label>
            <input v-model="form.image" type="text" class="w-full border p-2" />
        </div>
        <button type="submit" class="rounded bg-blue-500 px-4 py-2 text-white">Submit</button>
    </form>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const latitude = ref<number | null>(null);
const longitude = ref<number | null>(null);
const error = ref<string | null>(null);

navigator.geolocation.getCurrentPosition((position: GeolocationPosition) => {
    latitude.value = position.coords.latitude;
    longitude.value = position.coords.longitude;
});

const form = useForm({
    image: '',
    bulan: 2,
    tahun: 2025,
    user_id: 1,
    target_id: 2,
});

const submit = () => {
    form.post(route('save'), {
        onFinish: () => form.reset(),
    });
};
</script>
