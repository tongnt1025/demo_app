<template>
    <div class="container mt-2">
        <Alert v-if="showAlert" :type="alertType" :message="alertMessage" />
        <h2 class="mb-4">Danh sách bài viết</h2>

        <div v-if="isLoading" class="text-center my-3">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div v-else class="">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center w-5">STT</th>
                        <th class="text-center w-25">Tiêu đề</th>
                        <th class="text-center w-50">Nội dung</th>
                        <th class="text-center w-20">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in items" :key="item.id">
                        <td>{{ index + 1 }}</td>
                        <td v-if="editIndex !== index">{{ item.title }}</td>
                        <td v-else><input v-model="editItem.title" class="form-control"></td>
                        <td class="content" v-if="editIndex !== index">{{ item.content }}</td>
                        <td v-else><textarea v-model="editItem.content" class="form-control"></textarea></td>
                        <td>
                            <button v-if="editIndex === index" class="btn btn-success btn-sm me-2"
                                @click="saveEdit(index)">
                                Lưu
                            </button>
                            <button v-if="editIndex === index" class="btn btn-secondary btn-sm me-2"
                                @click="cancelEdit">
                                Hủy
                            </button>
                            <div class="d-flex gap-2">
                                <router-link :to="`/admin/edit-post/${item.id}`"
                                    class="btn btn-primary btn-sm">Sửa</router-link>
                                <button class="btn btn-danger btn-sm" @click="confirmDelete(item.id)">
                                    Xóa
                                </button>
                                <router-link :to="`/post/${item.id}`" class="btn btn-primary btn-sm">Xem chi tiết
                                </router-link>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="items.length == 0">
                        <td colspan="4" class="text-center">Không có bài viết nào</td>
                    </tr>
                </tbody>
            </table>
        </div>


        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">Bạn có chắc chắn muốn xóa bài viết này?</div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-danger" @click="deleteConfirmed"
                            data-bs-dismiss="modal">Xóa</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import { getPosts, deletePost } from '@/services/admin/PostService';
import Alert from "../../components/admin/Alert.vue";
import { Modal } from 'bootstrap';
import router from '../../router';


const itemToDeleteIndex = ref(null);
const isLoading = ref(false);
const showAlert = ref(false);
const alertType = ref("");
const alertMessage = ref("");
const items = ref([]);
const title = ref("");
const content = ref("");


const fetchPosts = async () => {
    isLoading.value = true;
    try {
        const response = await getPosts();
        items.value = response.data;
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
onMounted(fetchPosts);






const cancelEdit = () => {
    editIndex.value = null;
    editItem.title = '';
    editItem.content = '';
};

const confirmDelete = (id) => {
    itemToDeleteIndex.value = id;
    const deleteModal = new Modal(document.getElementById('deleteModal'));
    deleteModal.show();
};

const deleteConfirmed = async () => {
    try {
        await deletePost(itemToDeleteIndex.value);
        showAlertMessage("success", "Xóa bài viết thanh cong!");
        fetchPosts();
        itemToDeleteIndex.value = null;
    } catch (error) {
        showAlertMessage("danger", "Xóa bài viết thất bại");
    }
};
</script>

<style scoped>
.content {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    max-width: 100%;
    text-overflow: ellipsis;
    word-break: break-word;
    max-height: 56px;
}
</style>
