<template>
  <div class="bg-white shadow-md rounded-lg max-w-3xl px-6 py-20 mx-auto flex justify-center items-center">
    <div class="flex flex-col items-center">
      <form @submit.prevent="handleSubmit">
        <h1 class="text-4xl text-center font-bold pb-4">Add Or Update Book</h1>
        <label class="input input-bordered flex items-center mb-4">
          <input type="text" class="grow" v-model="book.title" placeholder="Title" />
        </label>
        <textarea class="textarea textarea-bordered mb-4 pr-72" v-model="book.summary" placeholder="Summary"></textarea>
        <label class="input input-bordered flex items-center mb-4">
          <input type="text" class="grow" v-model="book.stock" placeholder="Stock" />
        </label>
        <label class="form-control w-full max-w-xs mb-4">
          <select class="select select-bordered" v-if="category" v-model="book.category_id">
            <option disabled selected>Pick Category</option>
            <option :value="category.id" v-for="category in category" :key="category.id">
              {{ category.name }}
            </option>
          </select>
        </label>
        <input type="file" class="file-input file-input-bordered w-full max-w-xs" @change="handleUpload" />
        <input type="submit" value="Add Or Update" class="btn btn-neutral btn-block mt-5" />
      </form>

      <div v-if="errors && Object.keys(errors).length">
        <h3 class="text-red-600 font-bold">Please correct the following:</h3>
        <ul>
          <li v-for="error in errors" :key="error" class="text-red-600">
            {{ error[0] }}
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup>
import costumAPI from "@/api";
import { onMounted, ref } from "vue";
import { reactive } from "vue";
import { useAuthStore } from "@/stores/AuthStore";
import { useRoute, useRouter } from "vue-router";

const authStore = useAuthStore();
const route = useRoute();
const router = useRouter();
const errors = ref({});
const category = ref("");

const props = defineProps({
  isUpdate: {
    type: Boolean,
    default: false,
  },
  bookUpdate: {
    type: Object,
    default: () => ({}),
  }
})
const book = reactive({
  title: props.bookUpdate?.title || "",
  summary: props.bookUpdate?.summary || "",
  stock: props.bookUpdate?.stock || "",
  category_id: props.bookUpdate?.category_id || "",
  image: null,
});

const handleUpload = (event) => {
  const selectImage = event.target.files[0];

  book.image = selectImage;
};

const handleSubmit = async () => {
  try {
    let formData = new FormData();

    formData.append("title", book.title);
    formData.append("summary", book.summary);
    formData.append("stock", book.stock);
    formData.append("image", book.image);
    formData.append("category_id", book.category_id);

    if (!props.isUpdate) {
      await costumAPI.post("/book", formData, {
        headers: {
          Authorization: `Bearer ${authStore.tokenUser}`,
          "Content-Type": "multipart/form-data",
        },
      });
      alert("Book Added Successfully");
      router.push({ name: "Book" });
    } else {
      await costumAPI.post(
        `/book/${route.params.id}`, formData,
        {
          headers: {
            Authorization: `Bearer ${authStore.tokenUser}`,
            "Content-Type": "multipart/form-data",
          }
        },
      );

      alert("Book Updated Successfully");
      router.push({ name: "Book" });
    }
  } catch (error) {
    console.log(error);
  }
};



const fetchCategory = async () => {
  const { data } = await costumAPI.get("/category");
  category.value = data.data;
};

const fetchBookToUpdate = async () => {
  if (props.isUpdate && route.params.id) {
    const { data } = await costumAPI.get(`/book/${route.params.id}`);
    book.value = data.data;
    book.title = data.data.title;
    book.summary = data.data.summary;
    book.stock = data.data.stock;
    book.category_id = data.data.category_id;
  }
};

onMounted(async () => {
  await fetchCategory();
  await fetchBookToUpdate();
});
</script>