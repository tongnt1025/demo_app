<template>
  <Header />
  <div style="background-color:#F8F8FC;height: 100%;overflow: hidden;">
    <RouterView />
  </div>
  <Footer />
</template>

<script>
import Header from '@/components/client/Header.vue';
import Footer from '@/components/client/Footer.vue';

export default {
  components: {
    Header,
    Footer,
  }
}
</script>
