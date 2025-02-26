import axios from "axios";
import { API_URL_BE } from "../../config";
import { useAuthStore } from "../../stores/auth";

const getAuthHeaders = () => {
  const authStore = useAuthStore();
  return {
    Authorization: `Bearer ${authStore.token}`,
  };
};

export const addComment = async (data) => {
  try {
    const response = await axios.post(`${API_URL_BE}/comment/`,data,{
      headers: getAuthHeaders(),
    });
    return response.data;
  } catch (error) {
    throw error;
  }
};

export const deleteComment = async (id) => {
  try {
    const response = await axios.delete(`${API_URL_BE}/comment/${id}`,{
      headers: getAuthHeaders(),
    });
    return response.data;
  } catch (error) {
    throw error;
  }
};

export const updateComment = async (id, data) => {
  try {
    const response = await axios.post(`${API_URL_BE}/comment/${id}`, data, {
      headers: getAuthHeaders(),
    });
    return response.data;
  } catch (error) {
    throw error;
  }
};

export const getComments = async (id) => {
  try {
    const response = await axios.get(`${API_URL_BE}/comment/${id}`,{
      headers: getAuthHeaders(),
    });
    return response.data;
  } catch (error) {
    throw error;
  }
};

