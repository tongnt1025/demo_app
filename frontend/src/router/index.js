import { createRouter, createWebHistory } from "vue-router";
import Home from "@/views/client/Home.vue";
import AdminLayout from "@/layouts/AdminLayout.vue";
import ClientLayout from "@/layouts/ClientLayout.vue";
import Login from "@/views/client/Login.vue";
import Register from "@/views/client/Register.vue";
import Post from "@/views/admin/Post.vue";
import AddPost from "@/views/admin/AddPost.vue";
import EditPost from "@/views/admin/EditPost.vue";
import SinglePost from "../views/client/SinglePost.vue";
import { useAuthStore } from "@/stores/auth";

const routes = [
  {
    path: "/",
    component: ClientLayout,
    children: [
      { path: "", component: Home },
      { path: "login", component: Login },
      { path: "register", component: Register },
      { path: "post/:id", component: SinglePost },
    ],
  },
  {
    path: "/admin",
    component: AdminLayout,
    meta: { requiresAuth: true }, 
    children: [
      { path: "post", component: Post },
      { path: "add-post", component: AddPost },
      { path: "edit-post/:id", component: EditPost },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});


router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();
  const isAuthenticated = authStore.isAuthenticated; 
  if (to.meta.requiresAuth && !isAuthenticated) {
    next("/login"); 
  } else {
    next();
  }
});

export default router;
