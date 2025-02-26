import axios from "axios";
import { API_URL_BE } from "../../config";
export const login = async (data) => {
  try {
    axios.defaults.withCredentials = true;
    const response = await axios.post(`${API_URL_BE}/login`,data);
    return response.data;
  } catch (error) {
    throw error;
  }
};
export const register = async (data) => {
  try {
    axios.defaults.withCredentials = true;
    const response = await axios.post(`${API_URL_BE}/register`, data);
    return response.data;
  } catch (error) {
    throw error;
  }
};
