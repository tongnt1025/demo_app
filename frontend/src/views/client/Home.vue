<template>
  <div class="container mt-5">
    <Alert v-if="showAlert" :type="alertType" :message="alertMessage" />

    <h2 class="text-center mb-4">Danh sách bài viết  </h2>

    <div v-if="isLoading" class="text-center my-3">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>

    <div v-else class="row">
      <div v-for="(item, index) in items" :key="item.id" class="col-md-3 mb-3">
        <div class="card h-100 shadow-sm">
          
          <img 
            :src="placeholderImage"
            class="card-img-top" 
            alt="Ảnh bài viết"
          />
          
          <div class="card-body">
            <h5 class="card-title">{{ item.title }}</h5>
            <p class="card-text">{{ truncateText(item.content, 100) }}</p>
            <router-link :to="'/post/' + item.id" class="btn btn-primary">Xem bài viết</router-link>
          </div>
        </div>
      </div>
    </div>

    <div v-if="items.length === 0" class="text-center">
      <p>Không có bài viết nào</p>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { getPosts } from '@/services/admin/PostService';
import Alert from '../../components/admin/Alert.vue';
import placeholderImage from '@/assets/images/placeholder.png';

const items = ref([]);
const isLoading = ref(false);

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


const truncateText = (text, length) => {
  if (!text) return '';
  return text.length > length ? text.substring(0, length) + '...' : text;
};

onMounted(fetchPosts);
</script>

<style scoped>
.card {
  transition: transform 0.3s ease-in-out;
}

.card:hover {
  transform: translateY(-5px);
}


.card-img-top {
  width: 100%;
  height: auto;
  aspect-ratio: 16 / 9;
  object-fit: cover;
}
</style>
