<script setup>
    import { useForm } from "@inertiajs/vue3";
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import NavLink from '@/Components/NavLink.vue';

    import vueFilePond from "vue-filepond";
    import "filepond/dist/filepond.min.css";
    import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
    import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
    import FilePondPluginImagePreview from "filepond-plugin-image-preview";

    import InputError from '@/Components/InputError.vue';

    const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
    );

    const props = defineProps({ imageAnalysisResult: Object })

    const form = useForm({
        images: [],
    });
    
    let handleImagesFileUpload = (response) => {
        form.images.push(response);
    }

    const submitFiles = () => {
        form.post(route('upload.store'), {
            onFinish: () => form.reset(''),
        });
    };


</script>


<template>
    <Head title="Upload File" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
            Upload Performance Graphs
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="p-6 overflow-hidden bg-white shadow-sm sm:rounded-lg mx-4">
                    <div>
                        <div class="p-2 my-2">
                            <h2 class="text-3xl font-bold">Performance Graph Analysis Tool</h2>
                            <p class="text-sm text-gray-500">An AI-powered tool designed to analyze performance graph images,
                            providing detailed insights and summaries of website performance trends over a specified period.</p>
                        </div>

                    </div>
                    <form @submit.prevent="submitFiles" class="space-y-4">
                        <div class="mt-4">
                            <file-pond
                                name="images"
                                ref="pond"
                                label-idle="Upload multiple images at once"
                                v-bind:allow-multiple="true"
                                accepted-file-types="image/jpeg, image/png"
                                v-bind:server="{
                                    url:'',
                                    timeout:7000,
                                    process:{
                                        url:'/upload',
                                        method: 'POST',
                                        headers:{
                                            'X-CSRF-TOKEN': $page.props.csrf_token,
                                        },
                                        withCredentials:false,
                                        onload: handleImagesFileUpload,
                                        onerror: () => {}
                                    },
                                    revert: handleFilePondRevert,
                                }"
                                v-bind:file="form.images"
                                v-on:init="handleFilePondInit"
                                />
                                <p class="text-xs text-gray-400">You can upload multiple images</p>

                                <InputError class="mt-2" :message="form.errors.images" />
                        </div>
                        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded"
                        >
                        Start analysis
                        </button>
                    </form>
                </div>

                <div class="mt-10" v-if="imageAnalysisResult">
                    <div class="p-6 bg-white rounded-md">
                        <div class="flex justify-between">
                            <h1 class="text-3xl font-bold underline">Result</h1>
                            <NavLink
                                    :href="route('upload')"
                                    :active="route().current('upload')"
                                >
                                Refresh
                            </NavLink>
                        </div>
                        {{ imageAnalysisResult.candidates[0].content.parts[0].text }}
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>
