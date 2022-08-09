import "./bootstrap";

import { createApp } from "vue";
import App from "./Pages/app.vue";
import router from "./router";

createApp(App).use(router).mount("#app");
