<template>
    <div class="container mx-auto">
      <Home :grid="trendingBooks" :data="books" v-if="books.length > 0" />
    </div>
  </template>
  
  <script setup>
  import costumAPI from "@/api";
  import { onMounted, ref } from "vue";
  import { useAuthStore } from "@/stores/AuthStore";
  import Home from "@/components/layout/Home.vue";
  
  const authStore = useAuthStore();
  const trendingBooks = ref("");
  const books = ref("");
  
  const fetchBooks = async () => {
    const response = await costumAPI.get("/book");
  
    trendingBooks.value = response.data.trending;
    books.value = response.data.data;
  };
  
  onMounted(() => {
    fetchBooks();
  });
  
  
  </script>
  