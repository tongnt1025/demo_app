<template>
    <div class="container mt-2">

        <Alert v-if="showAlert" :type="alertType" :message="alertMessage" />
        <h2 class="mb-4">Sửa bài viết </h2>
        <div class="card p-4 mb-4">
            <div class="mb-3">
                <Input id="name" label="Tiêu đề" placeholder="Nhập tiêu đề" type="text" v-model="title" class="w-100" />
            </div>
            <div class="mb-3">
                <TextArea v-model="content" label="Nội dung" placeholder="Nhập nội dung" />
            </div>
            <button class="btn btn-primary" @click="editItem" :disabled="isLoading">
                <span v-if="isLoading" class="spinner-border spinner-border-sm"></span>
                <span v-else>Lưu</span>
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { updatePost, getPostById } from '@/services/admin/PostService';
import { useRoute } from 'vue-router';
import Input from '../../components/admin/Input.vue';
import TextArea from '../../components/admin/TextArea.vue';
import Alert from "../../components/admin/Alert.vue";
const route = useRoute();
const postId = route.params.id;
const isLoading = ref(false);
const title = ref('');
const content = ref('');
const showAlert = ref(false);
const alertType = ref("");
const alertMessage = ref("");
const fetchPost = async () => {
    isLoading.value = true;
    try {
        const response = await getPostById(postId);
        title.value = response.data.title;
        content.value = response.data.content;
    } catch (error) {
        console.error(error);
    } finally {
        isLoading.value = false;
    }
};
const showAlertMessage = (type, message) => {
    showAlert.value = false;
    setTimeout(() => {
        alertType.value = type;
        alertMessage.value = message;
        showAlert.value = true;
    }, 100);
};
onMounted(fetchPost);

const editItem = async () => {

    if (!title.value || !content.value) {
        showAlertMessage("danger", "Vui lý nhập đủ thông tin!");
        return;
    }
    try {
        isLoading.value = true;
        const formData = new FormData();
        formData.append('title', title.value);
        formData.append('content', content.value);
        formData.append('_method', 'PUT');
        const response = await updatePost(postId, formData);
        showAlertMessage("success", "Lưu thành công!");
    } catch (error) {
        showAlertMessage("danger", "Lưu không thành công!");
        console.error(error);
    } finally {
        isLoading.value = false;
    }
};

</script>

<style></style>
