<template>

    <GuestLayout>
        <a-form class="w-full" layout="vertical" :model="formState">

            <a-col v-for="(element, index) in form.fields" :span="24" class="draggable-item my-2">

                {{ element }}
                <a-form-item :label="element.label" :name="['fields', index, 'value']">
                    <component :is="element.type" style="width: 100%" v-model:value="formState[element.id].field_value">
                        <a-select-option
                            v-if="element.type === 'a-select'"
                            v-for="(option) in element.options"
                            :value="option.value">{{ option.label }}
                        </a-select-option>
                    </component>
                </a-form-item>
            </a-col>

            <a-form-item>
                <a-button type="primary" @click="onSubmit" class="fixed bottom-5 right-5 h-14">
                    Submit
                </a-button>
            </a-form-item>
        </a-form>
    </GuestLayout>
</template>
<script lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import {Checkbox, Col, DatePicker, Input, InputNumber, Select} from 'ant-design-vue';
import {reactive, ref, toRaw, UnwrapRef} from 'vue';
import {router} from '@inertiajs/vue3';

interface Element {
    id: number;
    name: string;
    type: string;
}

interface FormState {
    fields: Element[];
}

interface Form {
    id: bigint;
    name: string;
    description?: string;
    fields?: Element[];
}

export default {
    components: {
        GuestLayout,
        'a-col': Col,
        'a-input': Input,
        'a-input-number': InputNumber,
        'a-date-picker': DatePicker,
        'a-checkbox': Checkbox,
        'a-select': Select,
    },
    props: {
        form: Object
    },
    setup(props) {

        const form: UnwrapRef<FormState> = reactive<Form>(props.form.data);

        const formState: UnwrapRef<FormState> = reactive(form.fields.reduce((acc, obj) => {
            acc[obj.id] = {'field_id': obj.id, 'field_value': ''};
            return acc;
        }, {}));

        const onSubmit = () => {
            router.post(route('forms.submissions.store', [form.id]), toRaw(formState))
        };

        return {form, formState, open, onSubmit};
    }
};
</script>

