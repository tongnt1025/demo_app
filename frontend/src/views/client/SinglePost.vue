<template>
  <div class="comments-container container">
    <h4>{{ title}}</h4>
    <div class="mb-3">{{ content}}</div>
    <h6>Bình luận</h6>
    <CommentForm @comment-added="refreshComments" />
    <div v-if="loading" class="loading">
      Đang tải bình luận...
    </div>
    <CommentList v-else :comments="comments" @refresh-all="refreshComments" />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import CommentList from '@/components/client/CommentList.vue';
import CommentForm from '@/components/client/CommentForm.vue';
import { useRoute } from 'vue-router';
import { getComments } from '../../services/client/CommentService';
import { getPostById } from '../../services/admin/PostService';
const route = useRoute();
const postId = route.params.id;
const comments = ref([]);
const loading = ref(true);
const title = ref('');
const content = ref('');

onMounted(() => {
  fetchPost();
  refreshComments();
  
});

const fetchPost = async () => {
  try {
    const response = await getPostById(postId);
    title.value = response.data.title;
    content.value = response.data.content;

  } catch (error) {
    console.error("Lỗi khi tải bình luận:", error);
  }
}
const refreshComments = async () => {
  loading.value = true;
  try {
    const response = await getComments(postId);
    comments.value = response.data;
  } catch (error) {
    console.error("Lỗi khi tải bình luận:", error);
  } finally {
    loading.value = false;
  }
};

const fetchComments = async () => {
  try {
    const response = await getComments(postId);
    comments.value = response.data;
  } catch (error) {
    console.error("Lỗi khi tải bình luận:", error);
  }
};
</script>

<style scoped>
.comments-container {
  margin-top: 32px;
}

.loading {
  text-align: center;
  padding: 20px;
  color: #757575;
}
</style>