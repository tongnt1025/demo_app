<template>
    <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
        <div class="card p-4 shadow-lg" style="width: 400px">
            <h2 class="text-center mb-4">Đăng nhập</h2>

            <Alert v-if="showAlert" :type="alertType" :message="alertMessage" @close="showAlert = false" />

            <form @submit.prevent="login">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input v-model="email" id="email" class="form-control" placeholder="Nhập email" />
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <div class="input-group">
                        <input v-model="password" :type="showPassword ? 'text' : 'password'" id="password"
                            class="form-control" placeholder="Nhập mật khẩu" />
                        <button type="button" class="btn btn-outline-secondary" @click="togglePassword">
                            <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100" :disabled="isLoading">
                    <span v-if="isLoading" class="spinner-border spinner-border-sm"></span>
                    <span v-else>Đăng nhập</span>
                </button>

                <div class="text-center mt-3">
                    <router-link to="/register">Chưa có tài khoản? Đăng ký ngay</router-link>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import Alert from "@/components/admin/Alert.vue";
import { login as loginUser } from "@/services/client/UserService";
import { useAuthStore } from "@/stores/auth";
import router from "@/router";
const email = ref("");
const password = ref("");
const showPassword = ref(false);
const showAlert = ref(false);
const alertType = ref("success");
const alertMessage = ref("");
const isLoading = ref(false);
const authStore = useAuthStore();
const isValidEmail = (email) => {
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return emailPattern.test(email);
};

const showAlertMessage = (type, message) => {
    showAlert.value = false;
    setTimeout(() => {
        alertType.value = type;
        alertMessage.value = message;
        showAlert.value = true;
    }, 100);
};

const fetchLogin = async () => {
    isLoading.value = true;
    try {
        const formData = new FormData();
        formData.append("email", email.value);
        formData.append("password", password.value);
        const response = await loginUser(formData);
        const token = response.data.token;
        authStore.setToken(token);
        showAlertMessage("success", "Đăng nhập thành công!");
        setTimeout(() => {
            console.log("fdfdfdf");
            router.push("/admin/post");
        }, 2000);
    } catch (error) {
        showAlertMessage("danger", "Sai tài khoản hoặc mật khẩu");
    } finally {
        isLoading.value = false;
    }
}



const login = () => {
    if (!email.value || !password.value) {
        showAlertMessage("danger", "Vui lòng nhập đầy đủ thông tin!");
        return;
    }

    if (!isValidEmail(email.value)) {
        showAlertMessage("danger", "Email không hợp lệ!");
        return;
    }

    if (password.value.length < 8) {
        showAlertMessage("danger", "Mật khẩu phải có ít nhất 8 ký tự!");
        return;
    }

    fetchLogin();
};

const togglePassword = () => {
    showPassword.value = !showPassword.value;
};
</script>
