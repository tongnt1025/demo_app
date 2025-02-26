import { defineStore } from "pinia";

export const useAuthStore = defineStore("auth", {
  state: () => ({
    token: sessionStorage.getItem("token") || null,
  }),
  actions: {
    setToken(token) {
      this.token = token;
      sessionStorage.setItem("token", token);
    },
    clearToken() {
      this.token = null;
      sessionStorage.removeItem("token");
    },
  },
  getters: {
    isAuthenticated: (state) => !!state.token,
  },
});
