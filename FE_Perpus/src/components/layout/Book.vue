<template>
  <div class="mx-auto max-w-6xl px-8 rounded-xl min-h-[80vh]">
    <section>
      <div class="divider divider-neutral">
        <h1 class="text-3xl font-bold text-neutral">Hot Books</h1>
      </div>
      <div class="container mx-auto pb-2">
        <div class="card rounded-box grid h-full place-items-center">
          <div class="grid md:grid-cols-2 lg:grid-cols-3 mt-3 gap-4">
            <div class="card glass" v-for="item in props.grid" :key="item.id">
              <div class="w-full h-96 overflow-hidden rounded-l">
                <img :src="item.image" class="object-cover w-full h-full" />
              </div>
              <div class="absolute bottom-0 left-0 w-full bg-neutral bg-opacity-75 text-center py-2 rounded-l">
                <div class="font-bold">{{ item.title }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div v-for="(books, category) in groupedBooks" :key="category">
      <div class="divider divider-neutral">
        <h2 class="text-3xl font-bold mb-3 mt-5 text-neutral">{{ category }}</h2>
      </div>
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
        <div class="card bg-base-100 shadow-xl text-center" v-for="book in books" :key="books.id">
          <figure>
            <img :src="book.image" class="h-60" />
          </figure>
          <div class="card-body items-center">
            <h2 class="card-title">{{ book.title }}</h2>
            <div class="btn-group">
              <RouterLink class="btn btn-info mr-2" :to="{ name: 'Borrow', params: { id: book.id } }"
              v-if="authStore.tokenUser && authStore.currentUser">Borrow</RouterLink>

              <RouterLink class="btn btn-neutral mr-2" :to="{ name: 'DetailBook', params: { id: book.id } }">Details
              </RouterLink>

              <RouterLink  class="btn btn-warning mr-2" :to="{ name: 'UpdateBook', params: { id: book.id } }"
                v-if="authStore.currentUser.role_id === '9ca92327-a94b-4bf3-9808-068c242c9731'">Edit</RouterLink>

              <button class="btn btn-error ml-3 mt-2" @click="props.onDelete(book.id)"
                v-if="authStore.currentUser.role_id === '9ca92327-a94b-4bf3-9808-068c242c9731'">Delete</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useAuthStore } from "@/stores/AuthStore";
import { onMounted, ref, computed } from "vue";

const authStore = useAuthStore();

const props = defineProps({
  grid: {
    type: Array,
    required: true,
  },
  data: {
    type: Array,
    required: true,
  },
  onDelete: {
    type: Function,
    required: true,
  },
});

const groupedBooks = computed(() => {
  return props.data.reduce((acc, book) => {
    if (!acc[book.category]) {
      acc[book.category] = [];
    }
    acc[book.category].push(book);
    return acc;
  }, {});
});

</script>