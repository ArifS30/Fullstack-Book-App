<template>
  <div class="bg-white shadow-md rounded-lg max-w-3xl px-6 py-10 mx-auto">
    <h2 class="text-center text-3xl font-bold mb-5">Borrow Book</h2>
    <form @submit.prevent="borrowBook">
      <div class="mb-4">
        <label for="load_date" class="input items-center gap-2">Load Date:</label>
        <input type="date" id="load_date" v-model="form.Load_date" placeholder="Load Date" required>

      </div>
      <div class="mb-4">
        <label for="borrow_date" class="input items-center gap-2">Borrow Date:</label>
        <input type="date" id="borrow_date" v-model="form.Borrow_date" placeholder="Borrow Date" required>
      </div>
      <div class="mb-4">
        <label for="book_id" class="input   items-center gap-2">Book:</label>
        <select id="book_id" v-model="form.book_id" placeholder="Book" required>
          <option v-for="book in books" :value="book.id" :key="book.id">{{ book.title }}</option>
        </select>

      </div>
      <button type="submit" class="btn btn-neutral btn-block">Borrow Book</button>
    </form>
    <div v-if="error" class="alert alert-error mt-4">{{ error }}</div>
  </div>
</template>

<script>
import { useAuthStore } from '@/stores/AuthStore';
import costumAPI from '@/api';
import { useRouter } from 'vue-router';



export default {
  data() {
    return {
      form: {
        Load_date: "",
        Borrow_date: "",
        book_id: ""
      },
      books: [],
      error: ""
    }
  },
  mounted() {
    this.fetchBooks();
  },
  methods: {
    async fetchBooks() {
      try {
        const response = await costumAPI.get('/book');
        this.books = response.data.data;

      } catch (error) {
        this.error = 'Error fetching books.';
      }
    },
    async borrowBook() {
      try {
        const authStore = useAuthStore();
        const router = useRouter();

        const response = await costumAPI.post('/auth/borrow', this.form, {
          headers: {
            Authorization: `Bearer ${authStore.tokenUser}`,
          },
        });
        this.form.Load_date = '';
        this.form.Borrow_date = '';
        this.form.book_id = null;
        this.error = null;
        alert(response.data.message);
        await router.push({ name: 'Book' });
      } catch (error) {
        if (error.response.status === 422) {
          this.error = Object.values(error.response.data)[0][0];
        } else {
          this.error = 'Error borrowing book.';
        }
      }
    }
  }
}
</script>