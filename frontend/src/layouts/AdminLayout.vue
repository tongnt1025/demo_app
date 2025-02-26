<template>
  <Header />
  <div class="d-flex gap-2 w-100 h-100">
    <div class="col-2 col-md-2">
      <SideBar />
    </div>
    <div class="col-10 col-md-10" style="height: 100%;padding: 8px;">
      <RouterView />
    </div>
  </div>
  <Footer />
</template>

<script>
import Header from '@/components/admin/Header.vue';
import Footer from '@/components/admin/Footer.vue';
import SideBar from '@/components/admin/SideBar.vue';

export default {
  components: {
    Header,
    SideBar,
    Footer,
  }
}
</script>