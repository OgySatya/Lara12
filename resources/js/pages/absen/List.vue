<script lang="ts" setup>
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = ref({
    username: 'dsfsd',
    password: 'sdfsd',
});

function submit() {
    router.post('/run-bot', form.value);
}
</script>
<template>
    <form @submit.prevent="submit">
        <input v-model="form.username" type="text" placeholder="Username" />
        <input v-model="form.password" type="password" placeholder="Password" />
        <button type="submit">Run Bot</button>
    </form>
</template>
