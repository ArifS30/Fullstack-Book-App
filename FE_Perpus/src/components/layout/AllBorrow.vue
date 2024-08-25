<template>
  <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
    <div v-for="borrow in borrows" :key="borrow.id" class="border p-4 rounded-lg shadow-md">
      <div class="flex flex-col items-center">
        <img :src="borrow.list_book.image" alt="Book Cover" class="w-48 h-72 object-cover rounded-md mb-4">
        <h3 class="font-bold text-lg">{{ borrow.list_book.title }}</h3>
      </div>
      <div class="mt-4">
        <p>Borrower: {{ borrow.list_user.name }}</p>
        <p>Borrowed On: {{ formatDate(borrow.created_at) }}</p>
        <p>Returned On: {{ formatDate(borrow.updated_at) }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useAuthStore } from "@/stores/AuthStore";
import { ref, onMounted } from 'vue';
import costumAPI from '@/api';

const authStore = useAuthStore();

const borrows = ref([]);

onMounted(() => {
  fetchBorrows();
});

async function fetchBorrows() {
  try {
    const response = await costumAPI.get('/borrow', {
      headers: { Authorization: `Bearer ${authStore.tokenUser}` },
    });
    borrows.value = response.data.data;
  } catch (error) {
    console.error(error);
  }
}

function formatDate(dateString) {
  const date = new Date(dateString);
  return date.toLocaleDateString();
}
</script>