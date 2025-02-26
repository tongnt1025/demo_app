import { createApp } from 'vue'
import App from './App.vue'
import './style.css'
import { createPinia } from "pinia";
import router from './router';
import "bootstrap-icons/font/bootstrap-icons.css";
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js'; 

const pinia = createPinia();
const app = createApp(App);

app.use(pinia); 
app.use(router); 
app.mount('#app');
