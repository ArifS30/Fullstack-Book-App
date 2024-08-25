<template>
  <div class="bg-white shadow-md rounded-lg max-w-3xl px-6 py-20  mx-auto flex justify-center items-center">
    <div class="flex flex-col items-center">
      <div class="bg-neutral  w-28 h-28 rounded-full text-white flex items-center justify-center mb-4">
        <span class="text-3xl font-bold">{{ authStore.currentUser.name }}</span>
      </div>
      <div v-if="authStore.currentUser">
        <div class="mb-4 ">
          <p class="font-bold">Name: {{ authStore.currentUser.name }}</p>
        </div>
        <div class="mb-4">
          <p class="font-bold">Email: {{ authStore.currentUser.email }}</p>
        </div>
        <div class="mb-4" v-if="authStore.currentUser.profile && authStore.currentUser.profile.length > 0">
          <p class="font-bold">Bio: {{ authStore.currentUser.profile[0].bio }}</p>
        </div>
        <div class="mb-4">
          <p class="font-bold">Age: {{ authStore.currentUser.profile[0].age }}</p>
        </div>
        <RouterLink to="/profile/update" class="btn btn-neutral btn-block mt-5 text-white">Edit Profile</RouterLink>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useAuthStore } from '@/stores/AuthStore';
import { onMounted } from 'vue';
import { RouterLink } from 'vue-router';

const authStore = useAuthStore();
console.log(authStore.currentUser);

onMounted(() => {
  authStore.getMe();
});
</script>