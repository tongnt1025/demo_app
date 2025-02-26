import axios from "axios";
import { API_URL_BE } from "../../config";
import { useAuthStore } from "../../stores/auth";

const getAuthHeaders = () => {
  const authStore = useAuthStore();
  return {
    Authorization: `Bearer ${authStore.token}`,
  };
};

export const addPost = async (postData) => {
  try {
    const response = await axios.post(`${API_URL_BE}/post/add`, postData, {
      headers: getAuthHeaders(),
    });
    return response.data;
  } catch (error) {
    throw error;
  }
};

export const getPosts = async () => {
  try {
    const response = await axios.get(`${API_URL_BE}/post`);
    return response.data;
  } catch (error) {
    throw error;
  }
};

export const getPostById = async (id) => {
  try {
    const response = await axios.get(`${API_URL_BE}/post/${id}`);
    return response.data;
  } catch (error) {
    throw error;
  }
};

export const updatePost = async (id, postData) => {
  try {
    const response = await axios.post(`${API_URL_BE}/post/update/${id}`, postData, {
      headers: getAuthHeaders(),
    });
    return response.data;
  } catch (error) {
    throw error;
  }
};

export const deletePost = async (id) => {
  try {
    const response = await axios.delete(`${API_URL_BE}/post/delete/${id}`, {
      headers: getAuthHeaders(),
    });
    return response.data;
  } catch (error) {
    throw error;
  }
};
