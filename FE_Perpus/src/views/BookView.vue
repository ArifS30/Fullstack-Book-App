<template>
  <div class="container mx-auto">
    <div class="flex justify-end">
      <RouterLink :to="{ name: 'CreateBook' }" class="btn btn-neutral"
        v-if="authStore.currentUser.role_id === '9ca92327-a94b-4bf3-9808-068c242c9731'">Add Books</RouterLink>
    </div>
    <Book :grid="trendingBooks" :data="books" v-if="books.length > 0" :onDelete="deleteBook" />
  </div>
</template>

<script setup>
import { RouterLink } from "vue-router";
import costumAPI from "@/api";
import { onMounted, ref } from "vue";
import { useAuthStore } from "@/stores/AuthStore";
import Book from "@/components/layout/Book.vue";

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

const deleteBook = async (id) => {
  try {
    await costumAPI.delete(`/book/${id}`, {
      headers: { Authorization: `Bearer ${authStore.tokenUser}` },
    });
    fetchBooks();

    alert("Book Deleted Successfully");
  } catch (error) {
    console.log(error);

    alert("Internal Server Error");
  }
};

</script>