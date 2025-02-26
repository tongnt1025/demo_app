<template>
    <div class="">
        <div class="w-100">
            <div class="row flex-nowrap">
                <div class="bg-dark">
                    <div
                        class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">

                        <div  class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-file-earmark-post"></i> <router-link :to="'/admin/post'"
                                class="ms-1 d-none d-sm-inline text-white text-decoration-none">Quản lý bài viết </router-link>
                        </div>
                        <div  class="ms-2 nav-link px-0 align-middle">
                            <router-link :to="'/admin/add-post'" class="ms-4 d-none d-sm-inline text-white text-decoration-none">Thêm bài
                                viết</router-link>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import { RouterLink } from 'vue-router';
import router from '../../router';
export default {
    name: "SideBar"
}
</script>