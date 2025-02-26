<template>
  <div class="comment-form">
    <Alert v-if="showAlert" :type="alertType" :message="alertMessage" @close="showAlert = false" />
    <textarea v-model="content" placeholder="Viết bình luận của bạn..." :class="{ 'error': errors.content }"></textarea>
    <div v-if="errors.content" class="error-message">{{ errors.content }}</div>
    <button class="submit-btn" @click="submitComment" :disabled="submitting">
      {{ submitting ? 'Đang gửi...' : 'Gửi bình luận' }}
    </button>
  </div>
</template>

<script setup>
import { ref, defineProps, defineEmits } from 'vue';
import { useRoute } from 'vue-router';
import { addComment as createComment } from '../../services/client/CommentService';
import { useAuthStore } from "@/stores/auth";
import Alert from '../admin/Alert.vue';
const authStore = useAuthStore();
const emit = defineEmits(['comment-added']);
const content = ref('');
const submitting = ref(false);
const errors = ref({ content: '' });

const route = useRoute();
const postId = route.params.id;
const showAlert = ref(false);
const alertType = ref("success");
const alertMessage = ref("");
const props = defineProps({
  parentId: {
    type: Number,
    default: null
  }
});

const validateForm = () => {
  let isValid = true;
  errors.value = { content: '' };

  if (!content.value.trim()) {
    errors.value.content = 'Vui lòng nhập nội dung bình luận';
    isValid = false;
  }

  return isValid;
};
const showAlertMessage = (type, message) => {
  showAlert.value = false;
  setTimeout(() => {
    alertType.value = type;
    alertMessage.value = message;
    showAlert.value = true;
  }, 100);
};


const submitComment = async () => {
  if (!validateForm()) return;

  submitting.value = true;
  try {
    const formData = new FormData();
    formData.append('content', content.value);
    formData.append('post_id', postId);

    if (props.parentId) {
      formData.append('parent_id', props.parentId);
    }
    const response = await createComment(formData);
    content.value = '';
    emit('comment-added', response.data);
  } catch (error) {
    showAlertMessage("danger", "Vui lòng đăng nhập!");
  } finally {
    submitting.value = false;
  }
};
</script>

<style scoped>
.comment-form {
  margin-bottom: 20px;
}

textarea {
  width: 100%;
  height: 80px;
  padding: 12px 16px;
  border: 1px solid #e4e6e9;
  border-radius: 8px;
  font-family: inherit;
  resize: vertical;
  margin-bottom: 10px;
}

textarea:focus {
  outline: none;
  border-color: #1a73e8;
  box-shadow: 0 0 0 2px rgba(26, 115, 232, 0.1);
}

textarea.error {
  border-color: #ea4335;
}

.error-message {
  color: #ea4335;
  font-size: 0.85rem;
  margin-bottom: 8px;
}

.submit-btn {
  background: #1a73e8;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  font-weight: 500;
  transition: background-color 0.2s ease;
  cursor: pointer;
}

.submit-btn:hover {
  background: #1765c9;
}

.submit-btn:disabled {
  background: #a8c7f0;
  cursor: not-allowed;
}
</style>