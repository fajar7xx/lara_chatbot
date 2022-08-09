<script setup>
import API from "../utils/API";

const logout = async () => {
  console.log("logout now");
  try {
    // const response = await axios.get("http://localhost:8000/api/logout");
    const response = await API.get("logout");
    console.log(response.data);
    localStorage.clear();
    location.reload();
  } catch (e) {
    console.error(e);
  }
};
</script>

<template>
  <!-- This example requires Tailwind CSS v2.0+ -->
  <nav class="bg-gray-800">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
      <div class="relative flex items-center justify-between h-16">
        <div
          class="
            flex-1 flex
            items-center
            justify-center
            sm:items-stretch sm:justify-start
          "
        >
          <div class="flex-shrink-0 flex items-center">
            <span class="text-white font-large">Lara-Chatbot</span>
          </div>
          <div class="hidden sm:block sm:ml-6">
            <div class="flex space-x-4">
              <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
              <router-link
                :to="{ name: 'Dashboard' }"
                class="
                  text-white
                  hover:bg-gray-700 hover:text-white
                  px-3
                  py-2
                  rounded-md
                  text-sm
                  font-medium
                "
                aria-current="page"
                >Dashboard
              </router-link>

              <router-link
                :to="{ name: 'Chat' }"
                class="
                  text-gray-300
                  hover:bg-gray-700 hover:text-white
                  px-3
                  py-2
                  rounded-md
                  text-sm
                  font-medium
                "
              >
                Chat
              </router-link>
            </div>
          </div>
        </div>
        <div
          class="
            absolute
            inset-y-0
            right-0
            flex
            items-center
            pr-2
            sm:static sm:inset-auto sm:ml-6 sm:pr-0
          "
        >
          <div class="ml-3 relative">
            <div>
              <button
                type="button"
                class="
                  text-gray-300
                  hover:bg-gray-700 hover:text-white
                  px-3
                  py-2
                  rounded-md
                  text-sm
                  font-medium
                "
                @click="logout"
              >
                Logout
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

