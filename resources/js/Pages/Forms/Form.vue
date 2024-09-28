<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router, Link} from '@inertiajs/vue3';
import {ref} from 'vue';

defineProps<{
    forms: any;
}>();

const formColumns = ref([
    {
        title: 'Name',
        dataIndex: 'name',
        key: 'name',
    },
    {
        title: 'Description',
        dataIndex: 'description',
        key: 'description',
    },
    {
        title: 'Created At',
        dataIndex: 'created_at',
        key: 'created_at',
    },
    {
        title: 'Updated At',
        dataIndex: 'updated_at',
        key: 'updated_at',
    },
    {
        title: 'Action',
        key: 'action',
    },
])

const handleAdd = () => {
    router.get(route('forms.create'))
}

</script>

<template>
    <Head title="Form"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Forms</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <a-button class="editable-add-btn" style="margin-bottom: 8px" @click="handleAdd">Add New Form</a-button>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <a-table :dataSource="forms.data" :columns="formColumns">
                            <template #bodyCell="{ column, text, record }">
                                <template v-if="column.dataIndex === 'name'">
                                    <Link :href="route('forms.fields.index', [record.id])">
                                        {{ text }}
                                    </Link>
                                </template>

                                <template v-else-if="column.key === 'action'">
                                    <span>
                                        <Link :href="route('forms.show', [record.id])">
                                            Update
                                        </Link>
                                        <a-divider type="vertical"/>
                                        <Link :href="route('forms.fields.index', [record.id])">
                                            Show Fields
                                        </Link>
                                    </span>
                                </template>
                            </template>
                        </a-table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
