<template>
    <div class="mb-3">
        <label :for="id" class="form-label">{{ label }}</label>
        <textarea rows="6" :type="type" class="form-control" :id="id" :placeholder="placeholder" :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)" />
        <p class="text-danger">{{ error }}</p>
    </div>
</template>
<script setup>
defineProps({
    id: String,
    label: String,
    error: String,
    type: {
        type: String,
        default: "text"
    },
    placeholder: String,
    modelValue: String
})
defineEmits(['update:modelValue'])
</script>