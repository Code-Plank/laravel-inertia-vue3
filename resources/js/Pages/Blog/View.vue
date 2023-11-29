<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    blog : Object
});

</script>
<template>
    <Head :title="props.blog.heading" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <h1 class="text-2xl">{{props.blog.heading}}</h1>
                <div>
                    {{props.blog.description}}
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
