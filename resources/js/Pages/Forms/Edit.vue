<template>

    <Head title="Update Form"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Forms</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <a-form :model="formState" name="basic" autocomplete="off" @finish="onFinish"
                                @finishFailed="onFinishFailed">

                            <a-form-item label="Name" name="name"
                                         :rules="[{ required: true, message: 'Please input your form name!' }]">
                                <a-input v-model:value="formState.name"/>
                            </a-form-item>

                            <a-form-item label="Description" name="description">
                                <a-input v-model:value="formState.description"/>
                            </a-form-item>

                            <a-form-item :wrapper-col="{ offset: 8, span: 16 }">
                                <a-button type="primary" html-type="submit">Submit</a-button>
                            </a-form-item>

                        </a-form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import {reactive} from 'vue';

interface FormState {
    id: bigint;
    name: string;
    description?: string;
}

const props = defineProps<{
    form: any;
}>();

const formState = reactive<FormState>(props.form.data);

console.log(formState);

const onFinish = (values: FormState) => {
    console.log(values);
};

const onFinishFailed = (errorInfo: any) => {
    console.log(errorInfo);
};

</script>

