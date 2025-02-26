<template>
    <div id="content-wrapper" class="header-admin d-flex flex-column align-items-center py-1">
        <div class="d-flex gap-3 w-100 h-100 align-items-center">
            <div class="col-2 col-md-2 text-center d-flex align-items-center justify-content-center">
                <!-- <img style="width: 70px" src="@/assets/client/images/logo.png"> -->
            </div>
            <div class="col-10 col-md-10 text-right px-5 d-flex justify-content-end align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <p class="m-0">Admin</p>
                    <!-- <img class="rounded-circle" style="width: 40px;height: 40px" src="@/assets/client/images/logo.png"> -->
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: "Header",
}
</script>
<style scoped>
.header-admin {
    background-color: #fff !important;
    height: 70px !important;
    box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, .15) !important;
}
</style>