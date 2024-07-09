import './bootstrap';
import { createApp } from 'vue';
import HomeComponent from './components/HomeComponent.vue';

const app = createApp({
  components: {
    HomeComponent
  }
}).mount('#app');
