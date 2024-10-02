<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import {ref} from 'vue';

defineProps<{
    form: any;
}>();

const formColumns = ref([
    {
        title: 'Submitted At',
        dataIndex: 'submitted_at',
        key: 'submitted_at',
    },
    {
        title: 'Elements',
        dataIndex: 'element',
        key: 'element',
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
    }
])


</script>

<template>
    <Head title="Submissions"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Submissions: {{ form.data.name }}</h2>
            <a-typography-text type="secondary">{{ form.data.description }}</a-typography-text>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <a-table :dataSource="form.data.submissions" :columns="formColumns" :expand-column-width="150">
                            <template #bodyCell="{ column, text, record }">
                                <template v-if="column.dataIndex === 'element'">
                                    <a-tag v-for="payload in record.payloads" color="#2db7f5">{{ payload.type.substring(2) }}</a-tag>
                                </template>
                            </template>
                            <template #expandedRowRender="{ record }">
                                <a-list :grid="{ gutter: 16, xs: 1, sm: 2, md: 2, lg: 3, xl: 4, xxl: 4 }" :data-source="record.payloads">
                                    <template #renderItem="{ item }">
                                        <a-list-item>
                                            <a-card :title="item.label + '(' + item.name + ')'">
                                                {{ item.pivot.field_value }}
                                            </a-card>
                                        </a-list-item>
                                    </template>
                                </a-list>
                            </template>
                            <template #expandColumnTitle>
                                <span style="color: red">More</span>
                            </template>
                        </a-table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
