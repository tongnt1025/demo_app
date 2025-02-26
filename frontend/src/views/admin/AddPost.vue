<template>
    <div class="container mt-2">

        <Alert v-if="showAlert" :type="alertType" :message="alertMessage" />
        <h2 class="mb-4">Thêm bài viết </h2>
        <div class="card p-4 mb-4">
            <div class="mb-3">
                <Input id="name" label="Tiêu đề" placeholder="Nhập tiêu đề" type="text" v-model="title" class="w-100" />
            </div>
            <div class="mb-3">
                <TextArea v-model="content" label="Nội dung" placeholder="Nhập nội dung" />
            </div>
            <button class="btn btn-primary" @click="addItem" :disabled="isLoading">
                <span v-if="isLoading" class="spinner-border spinner-border-sm"></span>
                <span v-else>Thêm</span>
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { addPost } from '@/services/admin/PostService';
import Input from '../../components/admin/Input.vue';
import TextArea from '../../components/admin/TextArea.vue';
import Alert from "../../components/admin/Alert.vue";

const isLoading = ref(false);
const showAlert = ref(false);
const alertType = ref("");
const alertMessage = ref("");
const title = ref("");
const content = ref("");
const showAlertMessage = (type, message) => {
    showAlert.value = false;
    setTimeout(() => {
        alertType.value = type;
        alertMessage.value = message;
        showAlert.value = true;
    }, 100);
};
const addItem = async () => {

    if (!title.value || !content.value) {
        showAlertMessage("danger", "Vui lý nhập đủ thông tin!");
        return;
    }
    try {
        isLoading.value = true;
        const newItem = {
            title: title.value,
            content: content.value
        };
        await addPost(newItem);
        showAlertMessage("success", "Thêm bài viết thanh cong!");
        title.value = "";
        content.value = "";

    } catch (error) {
        console.error(error); showAlertMessage("danger", "Lỗi khi thêm bài viết!");
    } finally {
        isLoading.value = false;
    }
};
</script>

<style>

</style>
