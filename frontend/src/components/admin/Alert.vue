<template>
    <div v-if="visible" class="alert" :class="alertClass" role="alert">
        {{ message }}
        <button type="button" class="btn-close" @click="closeAlert"></button>
    </div>
</template>

<script setup>
import { ref, defineProps, watchEffect } from "vue";

const props = defineProps({
    type: { type: String, default: "success" },
    message: { type: String, required: true }, 
});

const visible = ref(true);


const alertClass = ref({
    "alert-success": props.type === "success",
    "alert-danger": props.type === "danger",
    "alert-warning": props.type === "warning",
    "alert-info": props.type === "info",
});


watchEffect(() => {
    visible.value = true;
    setTimeout(() => {
        visible.value = false;
    }, 2000); 
});


const closeAlert = () => {
    visible.value = false;
};
</script>

<style scoped>
.alert {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1050;
}
</style>
