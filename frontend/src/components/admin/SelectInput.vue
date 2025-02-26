<template>
<label :for="id" class="form-label">{{ label }}</label>
    <select :value="modelValue" @change="$emit('update:modelValue', $event.target.value)" class="form-select"
        aria-label="Default select example">
        <option  v-for="option in options" :key="option.id" :value="option.id">{{ option.name }}</option>
    </select>
</template>

<script setup>

defineProps({
    modelValue: {
        type: String,
        default: ''
    },
    options: {
        type: Array,
        default: []
    },
    label: {
        type: String,
        default: ''
    },

})

</script>