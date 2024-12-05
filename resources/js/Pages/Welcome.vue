<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome" />
    <div class="bg-gray-50 text-black/50">
        <div
            class="relative flex min-h-screen flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white"
        >
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">

                <main class="mt-6">
                    <div class="grid grid-cols-1 place-content-center text-center max-w-4xl mx-auto">
                        <h1 class="md:text-6xl text-4xl font-bold">SUSO Digital Performance Graph Insights</h1>
                        <p class="text-yellow-600 mt-4 text-base">Upload graphs and get AI-driven analysis of your website’s performance trends.</p>

                        <div class="mt-8">
                            <nav v-if="canLogin" class="">
                                <Link
                                    v-if="$page.props.auth.user"
                                    :href="route('dashboard')" class="bg-gray-500 text-white p-4 rounded-full mr-2">
                                    Dashboard
                                </Link>

                                <template v-else>
                                    <Link v-if="canRegister" :href="route('register')" class="bg-gray-500 text-white p-4 rounded-full mr-2" >
                                Register
                            </Link>
                            <Link :href="route('login')">
                                Log in
                            </Link>
                                </template>
                            </nav>
                        </div>
                    </div>
                </main>

                <footer
                    class="py-16 text-center text-sm text-black dark:text-white/70"
                >
                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </footer>
            </div>
        </div>
    </div>
</template>
