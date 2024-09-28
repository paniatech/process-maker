<template>
    <a-row class="groups">
        <a-col :span="5" class="min-h-screen border-b border-gray-200 p-4 flex justify-center items-center">
            <a-row>
                <Container behaviour="copy" group-name="1" :get-child-payload="getChildPayload">
                    <Draggable v-for="element in elements" drag-handle-selector>
                        <a-col :span="24" class="draggable-item my-2">
                            <label>{{ element.name }}</label>
                            <component :is="element.type" style="width: 100%"/>
                        </a-col>
                    </Draggable>
                </Container>
            </a-row>
        </a-col>
        <a-col :span="19" class="min-h-screen bg-gray-100 flex justify-center items-center">
            <a-row style="width: 80%">
                <a-form class="w-full min-h-screen" layout="vertical" :model="formState">
                    <Container class="h-full" group-name="1" @drop="onDrop($event)">
                        <Draggable v-for="(element, index) in formState.fields" drag-handle-selector>
                            <a-col :span="24" class="draggable-item my-2">
                                <a-form-item :label="element.label" :name="['fields', index, 'value']">
                                    <component :is="element.type" style="width: 100%">
                                        <a-select-option
                                            v-if="element.type === 'a-select'"
                                            v-for="(option) in element.options"
                                            :value="option.value">{{ option.label }}
                                        </a-select-option>
                                    </component>
                                    <MinusCircleOutlined class="dynamic-delete-item" @click="removeField(element)"/>
                                </a-form-item>
                            </a-col>
                        </Draggable>
                    </Container>
                    <a-form-item v-if="formState.fields.length > 0">
                        <a-button type="primary" @click="onSubmit" class="fixed bottom-5 right-5 h-14">
                            Update Form Elements
                        </a-button>
                    </a-form-item>
                </a-form>
            </a-row>
        </a-col>
    </a-row>

    <a-modal v-model:open="open" width="1000px" title="Define Properties" @ok="handleOk">

        <a-form :model="modalState" name="basic" layout="vertical" autocomplete="off">

            <a-form-item label="field label" name="label"
                         :rules="[{ required: true, message: 'Please input your filed label!' }]">
                <a-input v-model:value="modalState.label"/>
            </a-form-item>
            <a-form-item label="Name" name="name"
                         :rules="[{ required: true, message: 'Please input your filed name!' }]">
                <a-input v-model:value="modalState.name"/>
            </a-form-item>
            <a-form-item name="is_required">
                <a-checkbox v-model:checked="modalState.is_required">Required?</a-checkbox>
            </a-form-item>
            <a-row v-if="modalState.id === 5" :gutter="24">
                <template v-for="(option, index) in modalState.options" :key="index">
                    <a-col :span="12">
                        <a-form-item name="label" label="Label">
                            <a-input v-model:value="modalState.options[index].label"
                                     placeholder="Label of option"></a-input>
                        </a-form-item>
                    </a-col>
                    <a-col :span="10">
                        <a-form-item name="value" label="Value">
                            <a-input v-model:value="modalState.options[index].value"
                                     placeholder="Value of option"></a-input>
                        </a-form-item>
                    </a-col>
                    <MinusCircleOutlined v-show="modalState.options.length > 1" class="dynamic-delete-button"
                                         @click="removeOption(option)"/>
                </template>
            </a-row>
            <a-form-item v-if="modalState.id === 5">
                <a-button type="dashed" style="width: 100%" @click="addOptions">
                    <PlusOutlined/>
                    Add Options
                </a-button>
            </a-form-item>
        </a-form>
    </a-modal>
</template>
<script lang="ts">
import {Container, Draggable} from "vue-dndrop";
import {Checkbox, Col, DatePicker, Input, InputNumber, Select} from 'ant-design-vue';
import {reactive, ref, toRaw, UnwrapRef} from 'vue';
import {router} from '@inertiajs/vue3';
import {MinusCircleOutlined, PlusOutlined} from '@ant-design/icons-vue';

const input = {
    id: 1,
    name: 'Input Box',
    type: 'a-input',
}

const date = {
    id: 2,
    name: 'Date Picker',
    type: 'a-date-picker',
}

const number = {
    id: 3,
    name: 'Number Input Box',
    type: 'a-input-number',
}

const checkbox = {
    id: 4,
    name: 'Check Box',
    type: 'a-checkbox',
}

const combobox = {
    id: 5,
    name: 'Combo Box',
    type: 'a-select',
}

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
    fields?: any;
}


const applyDrag = (arr, dragResult) => {
    const {removedIndex, addedIndex, payload} = dragResult;
    if (removedIndex === null && addedIndex === null) return arr;

    const result = [...arr];
    let itemToAdd = payload;

    if (removedIndex !== null) {
        itemToAdd = result.splice(removedIndex, 1)[0];
    }

    if (addedIndex !== null) {
        result.splice(addedIndex, 0, itemToAdd);
    }

    return result;
};

export default {
    components: {
        Container,
        Draggable,
        MinusCircleOutlined,
        PlusOutlined,
        'a-col': Col,
        'a-input': Input,
        'a-input-number': InputNumber,
        'a-date-picker': DatePicker,
        'a-checkbox': Checkbox,
        'a-select': Select,
    },
    props: {
        form: Array
    },
    setup(props) {

        const form = reactive<Form>(props.form.data);
        const open = ref<boolean>(false);

        const formState: UnwrapRef<FormState> = reactive({
            fields: form.fields ?? [],
        });

        const defaultModalState = {
            id: 0,
            label: '',
            name: '',
            options: [],
            is_required: false,
        };

        const modalState: UnwrapRef<FormState> = reactive(defaultModalState);

        const formTemp: UnwrapRef<FormState> = reactive({
            fields: [],
        });

        const onSubmit = () => {
            router.post(route('forms.fields.store', [form.id]), toRaw(formState))
        };

        const addOptions = () => {
            modalState.options.push({label: '', value: ''})
        };

        const removeOption = (item) => {
            const index = modalState.options.indexOf(item);

            if (index !== -1) modalState.options.splice(index, 1);
        };

        const removeField = (item) => {
            const index = formState.fields.indexOf(item);

            if (index !== -1) formState.fields.splice(index, 1);
        };

        return {
            form, open, formState, defaultModalState, modalState, formTemp,
            addOptions, onSubmit, removeOption, removeField,
        };
    },
    data() {
        return {
            elements: [input, date, number, checkbox, combobox],
        };
    },
    methods: {
        onDrop(dropResult) {

            this.formTemp.fields = applyDrag(this.formState.fields, dropResult);
            const {addedIndex, payload} = dropResult;

            this.modalState.id = payload.id ?? 0;
            this.modalState.index = addedIndex;

            this.open = true;
        },
        getChildPayload(index) {
            return this.elements[index];
        },

        handleOk() {
            this.formState.fields = this.formTemp.fields;

            this.formState.fields[this.modalState.index] =
                {...this.formState.fields[this.modalState.index], ...this.modalState};

            this.open = false;
        }
    },
};
</script>
<style scoped>
.dynamic-delete-item {
    cursor: pointer;
    position: relative;
    font-size: 15px;
    color: #999;
    transition: all 0.3s;
}

.dynamic-delete-button {
    cursor: pointer;
    position: relative;
    top: 40px;
    font-size: 24px;
    color: #999;
    transition: all 0.3s;
}

.dynamic-delete-button:hover {
    color: #777;
}

.dynamic-delete-button[disabled] {
    cursor: not-allowed;
    opacity: 0.5;
}
</style>
