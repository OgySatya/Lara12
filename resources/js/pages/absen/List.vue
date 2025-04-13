<script lang="ts" setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const form = ref({
    username: '',
    password: '',
})

function submit() {
    router.post('/run-bot', form.value)
}
</script>
<template>
    <form @submit.prevent="submit">
        <input v-model="form.username" type="text" placeholder="Username" />
        <input v-model="form.password" type="password" placeholder="Password" />
        <button type="submit">Run Bot</button>
    </form>
</template>