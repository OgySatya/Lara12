<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { defineProps } from 'vue';


</script>
<template>

    <!-- <Head title="Laporan" />

    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold">John Doe</h1>
            <p class="text-gray-600">Software Engineer</p>
        </div>
        <div class="mb-6">
            <h2 class="text-2xl font-semibold mb-2">Contact Information</h2>
            <p>Email: john.doe@example.com</p>
            <p>Phone: (123) 456-7890</p>
            <p>LinkedIn: linkedin.com/in/johndoe</p>
        </div>
        <div class="mb-6">
            <h2 class="text-2xl font-semibold mb-2">Education</h2>
            <p><strong>University of Example</strong> - Bachelor of Science in Computer Science</p>
            <p>Graduated: 2020</p>
        </div>
        <div class="mb-6">
            <h2 class="text-2xl font-semibold mb-2">Experience</h2>
            <p><strong>Example Company</strong> - Software Engineer</p>
            <p>June 2020 - Present</p>
            <ul class="list-disc list-inside">
                <li>Developed and maintained web applications using Laravel and Vue.js</li>
                <li>Collaborated with cross-functional teams to define and design new features</li>
                <li>Optimized applications for maximum speed and scalability</li>
            </ul>
        </div>
        <div class="mb-6" style="display:grid">
            <h2 class="text-2xl font-semibold mb-2">Skills</h2>
            <ul class="list-disc list-inside">
                <li>Programming Languages: PHP, JavaScript, Python</li>
                <li>Frameworks: Laravel, Vue.js, Django</li>
                <li>Tools: Git, Docker, Jenkins</li>
            </ul>
            <img style="width: 400px"
                src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f5/Oda_emblem.svg/1200px-Oda_emblem.svg.png"
                alt="tag">
            <img style="width: 400px"
                src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f5/Oda_emblem.svg/1200px-Oda_emblem.svg.png"
                alt="tag">
            <img style="width: 400px"
                src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f5/Oda_emblem.svg/1200px-Oda_emblem.svg.png"
                alt="tag">
            <img style="width: 400px"
                src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f5/Oda_emblem.svg/1200px-Oda_emblem.svg.png"
                alt="tag">
            <img style="width: 400px"
                src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f5/Oda_emblem.svg/1200px-Oda_emblem.svg.png"
                alt="tag">
            <img style="width: 400px"
                src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f5/Oda_emblem.svg/1200px-Oda_emblem.svg.png"
                alt="tag">
            <img style="width: 400px"
                src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f5/Oda_emblem.svg/1200px-Oda_emblem.svg.png"
                alt="tag">
        </div>
    </div> -->
    <div class="p-8 text-center">
        <h1 class="text-3xl font-bold">Invoice #12345</h1>
        <p class="text-gray-600">Generated using Laravel, Inertia, Vue, and Browsershot.</p>

        <table class="mt-6 w-full border">
            <tr class="bg-gray-200">
                <th class="p-2">Item</th>
                <th class="p-2">Price</th>
            </tr>
            <tr>
                <td class="p-2 border">Product A</td>
                <td class="p-2 border">$50</td>
            </tr>
            <tr>
                <td class="p-2 border">Product B</td>
                <td class="p-2 border">$30</td>
            </tr>
        </table>

        <p class="mt-4 font-bold">Total: $80</p>
    </div>
</template>