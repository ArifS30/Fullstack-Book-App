<template>
   <Header v-if="!authStore.currentUser"/>
  <NavComponent />
  <main class="mx-auto max-w-6xl px-8 py-20 my-10 rounded-xl min-h-[80vh]">
    <div>
      <RouterView v-slot="{ Component, route }">
        <Transition name="fade" mode="out-in">
          <component :is="Component" :key="route.path" />
        </Transition>
      </RouterView>
    </div>
  </main>

</template>

<script setup>
import {RouterView } from 'vue-router'
import NavComponent from '@/components/layout/NavComponent.vue';
import Header from '@/components/layout/Header.vue';
import { useAuthStore } from '@/stores/AuthStore';
const authStore = useAuthStore();
</script>


<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>