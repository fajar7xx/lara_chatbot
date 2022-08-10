<script setup>
import { reactive, onMounted, watch, ref } from "vue";
import API from "../utils/API";
import TheNavbar from "../Components/TheNavbar.vue";

const newMessage = ref("");
const messageEnded = ref(false);
const messages = ref([]);

onMounted(() => {
  initMessage();
});

const initMessage = async () => {
  try {
    const response = await API.post("/chat/init");
    console.log(response);
    fetchMessage(response.data);
  } catch (e) {
    console.error(SVGComponentTransferFunctionElement);
  }
};

const addMessage = async () => {
  try {
    const response = await API.post("/chat/send", messages);
    console.log(response);
  } catch (e) {
    console.error(e);
  }
};

const sendMessage = () => {
  if (newMessage.value.trim()) {
    addMessage(newMessage.value);
  }
};

const fetchMessage = (messages) => {
  if (messages.value) {
    messages.value.forEach((element) => {
      messages.value.push(element);
    });
  }
};
</script>

<template>
  <div>
    <TheNavbar />

    <!-- <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Chat Component</div>

                        <div class="card-body" v-if="!isEnded">
                            <div class="row mb-2">
                                <div class="mb-12" v-for="message in messages" v-bind:key="message.id">
                                    <label for="email" :class="
                                        message.sender_name == message.sender_id
                                            ? 'col-md-12 text-md-start'
                                            : 'col-md-12 text-md-end'
                                    ">{{ message.sender_name ? message.sender_name : "You" }} :
                                        {{ message.message }}
                                    </label>
                                </div>
                                <br />
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <input id="new-message" type="text" class="form-control" v-model="newMessage"
                                        name="new-message" required @keyup.enter="sendMessage" />
                                </div>
                            </div>
                        </div>
                        <div class="card-body" v-else>
                            <div class="row mb-2">
                                <div class="mb-12" v-for="message in messages" v-bind:key="message.id">
                                    <label for="email" :class="
                                        message.sender_name == message.sender_id
                                            ? 'col-md-12 text-md-start'
                                            : 'col-md-12 text-md-end'
                                    ">{{ message.sender_name ? message.sender_name : "You" }} :
                                        {{ message.message }}
                                    </label>
                                </div>
                                <br />
                                <label for="notice" class="col-md-12 text-md-start">
                                    chating session is done, this page will redirected in seconds!!
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

    <div class="container mx-auto mt-8">
      <div class="flex items-center justify-center min-h-screen">
        <div class="rounded-xl border p-5 shadow-md w-9/12 bg-white">
          <!-- show messages -->
          <div class="row mb-2">
            <div
              class="mb-12"
              v-for="message in messages"
              v-bind:key="message.id"
            >
              <label
                for="email"
                :class="
                  message.sender_name == message.sender_id
                    ? 'col-md-12 text-md-start'
                    : 'col-md-12 text-md-end'
                "
                >{{ message.sender_name ? message.sender_name : "You" }} :
                {{ message.message }}
              </label>
            </div>
            <br />
          </div>

          <form @submit.prevent="sendMessage">
            <label for="chat" class="sr-only">Your message</label>
            <div
              class="
                flex
                items-center
                py-2
                px-3
                bg-gray-50
                rounded-lg
                dark:bg-gray-700
              "
            >
              <textarea
                id="chat"
                rows="1"
                class="
                  block
                  mx-4
                  p-2.5
                  w-full
                  text-sm text-gray-900
                  bg-white
                  rounded-lg
                  border border-gray-300
                  focus:ring-blue-500 focus:border-blue-500
                  dark:bg-gray-800
                  dark:border-gray-600
                  dark:placeholder-gray-400
                  dark:text-white
                  dark:focus:ring-blue-500
                  dark:focus:border-blue-500
                "
                placeholder="Your message..."
                required
                v-model="newMessage"
                @keyup.enter="sendMessage"
              ></textarea>
              <button
                type="submit"
                class="
                  inline-flex
                  justify-center
                  p-2
                  text-blue-600
                  rounded-full
                  cursor-pointer
                  hover:bg-blue-100
                  dark:text-blue-500 dark:hover:bg-gray-600
                "
              >
                <svg
                  aria-hidden="true"
                  class="w-6 h-6 rotate-90"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"
                  ></path>
                </svg>
                <span class="sr-only">Send message</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
