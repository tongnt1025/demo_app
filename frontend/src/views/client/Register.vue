<template>
    <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
        <div class="card p-4 shadow-lg" style="width: 400px">
            <h2 class="text-center mb-4">Đăng ký</h2>

            <Alert v-if="showAlert" :type="alertType" :message="alertMessage" @close="showAlert = false" />

            <form @submit.prevent="register">
                <div class="mb-3">
                    <label for="name" class="form-label">Họ và tên</label>
                    <input v-model="name" type="text" id="name" class="form-control" placeholder="Nhập họ và tên" required />
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input v-model="email" id="email" class="form-control" placeholder="Nhập email" required />
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <div class="input-group">
                        <input v-model="password" :type="showPassword ? 'text' : 'password'" id="password" class="form-control"
                            placeholder="Nhập mật khẩu" required />
                        <button type="button" class="btn btn-outline-secondary" @click="togglePassword">
                            <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Xác nhận mật khẩu</label>
                    <div class="input-group">
                        <input v-model="confirmPassword" :type="showConfirmPassword ? 'text' : 'password'" id="confirmPassword"
                            class="form-control" placeholder="Nhập lại mật khẩu" required />
                        <button type="button" class="btn btn-outline-secondary" @click="toggleConfirmPassword">
                            <i :class="showConfirmPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-success w-100" :disabled="isLoading">
                    <span v-if="isLoading" class="spinner-border spinner-border-sm"></span>
                    <span v-if="!isLoading">Đăng ký</span>
                </button>

                <div class="text-center mt-3">
                    <router-link to="/login">Đã có tài khoản? Đăng nhập ngay</router-link>
                </div>
            </form>
        </div>

        
    </div>
</template>

<script setup>
import { ref } from "vue";
import Alert from "@/components/admin/Alert.vue";
import router from "@/router";
import { register as registerUser } from "@/services/client/UserService";

const name = ref("");
const email = ref("");
const password = ref("");
const confirmPassword = ref("");
const showPassword = ref(false);
const showConfirmPassword = ref(false);
const showAlert = ref(false);
const alertType = ref("success");
const alertMessage = ref("");
const isLoading = ref(false);

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

const fetchRegister = async () => {
    isLoading.value = true; 

    const formData = new FormData();
    formData.append("name", name.value);
    formData.append("email", email.value);
    formData.append("password", password.value);

    try {
        await registerUser(formData);
        showAlertMessage("success", "Đăng ký thành công!");
        setTimeout(() => {
            router.push("/login");
        }, 2000);
    } catch (error) {
        console.error("Lỗi khi đăng ký:", error);
        if (error.response && error.response.status === 409) {
            showAlertMessage("danger", "Email đã được sử dụng. Vui lòng thử email khác!");
        } else {
            showAlertMessage("danger", "Đăng ký thất bại! Vui lòng thử lại.");
        }
    } finally {
        isLoading.value = false; 
    }
};

const register = () => {
    if (!name.value || !email.value || !password.value || !confirmPassword.value) {
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

    if (password.value !== confirmPassword.value) {
        showAlertMessage("danger", "Mật khẩu xác nhận không khớp!");
        return;
    }

    fetchRegister();
};

const togglePassword = () => {
    showPassword.value = !showPassword.value;
};

const toggleConfirmPassword = () => {
    showConfirmPassword.value = !showConfirmPassword.value;
};
</script>

<style scoped>

.spinner-border {
    margin-right: 8px;
}
</style>
