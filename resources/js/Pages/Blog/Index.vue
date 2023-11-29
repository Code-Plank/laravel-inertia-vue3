<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryLink from '@/Components/PrimaryLink.vue';
import Pagination from '@/Components/Pagination.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    blogs : Object,
    filters : Object,
    message : String
});

const filters = {
    filter: props.filters.filter,
}
const form = useForm(filters);

const deleteTrade = (id) => {
    if (confirm("Are you sure you want to move this to trash")) {
	   form.delete(route('blogs.destroy',{id:id}), {
		  preserveScroll: true,
	   });
    }
};
</script>
<template>
	<Head title="Blogs" />
	<AuthenticatedLayout>
		<template #header>
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"><a :href="route('blogs.index')">Blogs</a> <PrimaryLink :href="route('blogs.index', {filter:'only'})" class="max-w-xl ml-2" >View Trashed</PrimaryLink> <PrimaryLink :href="route('blogs.create')" class="max-w-xl ml-2" >Add Blog</PrimaryLink></h2>
		</template>
		<div class="py-12">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
			  <div
				 v-if="props.message"
				 class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
				 role="alert"
			  >
				 <span class="font-medium">
					{{ props.message }}
				 </span>
			  </div>
			   <div class="bg-white rounded-md shadow overflow-x-auto">
				<table class="w-full whitespace-nowrap">
				  <thead>
				    <tr class="text-left font-bold">
					 <th class="pb-4 pt-6 px-6">ID</th>
					 <th class="pb-4 pt-6 px-6">Heading</th>
					 <th class="pb-4 pt-6 px-6">Publsihed Date</th>
					 <th class="pb-4 pt-6 px-6">Actions</th>
				    </tr>
				  </thead>
				  <tbody>
				    <tr v-for="entry in props.blogs.data" :key="entry.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
					 <td class="border-t">
					   <span class="flex items-center px-6 py-4 focus:text-indigo-500">
						{{ entry.heading }}
					   </span>
					 </td>
					 <td class="border-t">
					   <span class="flex items-center px-6 py-4 focus:text-indigo-500">
						{{ entry.slug }}
					   </span>
					 </td>
					 <td class="border-t">
					   <span class="flex items-center px-6 py-4 focus:text-indigo-500">
						{{ entry.created_at }}
					   </span>
					 </td>
					 <td class="border-t" >
					 	<PrimaryLink v-if="entry.deleted_at == null" :href="route('blogs.show', {'id': entry.id})" class="max-w-xl ml-2" >VIEW</PrimaryLink>
					   	<PrimaryLink v-if="entry.deleted_at == null" :href="route('blogs.edit', {'id': entry.id})" class="max-w-xl ml-2" >EDIT</PrimaryLink>
					   	<DangerButton
						class="ml-3"
						@click="deleteTrade(entry.id)" v-if="entry.deleted_at == null"
						>
						Trash
					   </DangerButton>
					 </td>
				    </tr>
				    <tr v-if="props.blogs.data.length === 0">
					 <td class="px-6 py-4 border-t" colspan="4">No posts found.</td>
				    </tr>
				  </tbody>
				</table>
			   </div>
			   <pagination class="mt-6" :links="props.blogs.links" />
			</div>
		</div>
	</AuthenticatedLayout>
</template>