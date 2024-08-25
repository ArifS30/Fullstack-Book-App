<template>
    <main class="mx-auto max-w-6xl px-8 py-8 my-10 rounded-xl min-h-[80vh]">
      <div class="bg-white shadow-md rounded-lg max-w-3xl px-6 py-10 mx-auto">
        <h1 class="text-center text-3xl font-bold mb-5">
          {{ props.title }} 
        </h1>
        <form @submit.prevent="handleSubmit()">
          <label class="input input-bordered flex items-center">
            <input type="text" class="grow mb-2" placeholder="Add Category Name" v-model="name" />
          </label>
          <input type="submit" :value="props.title" class="btn btn-neutral btn-block mt-5" />
        </form>
      </div> 
    </main>
  </template>
  
  <script setup>
  import { onMounted, ref } from "vue";
  import costumAPI from "@/api";
  import { useAuthStore } from "@/stores/AuthStore";
  import { useRouter, useRoute } from "vue-router";
  
  const props = defineProps({
    title: {
      type: String,
      required: true,
    },
    isUpdate: {
      type: Boolean,
      default: false,
    },
  });
  
  const route = useRoute();
  
  const CategoryById = async () => {
    const { data } = await costumAPI(`/category/${route.params.id}`);
    name.value = data.data.name;
  };
  
  const authStore = useAuthStore();
  const router = useRouter();
  const name = ref("");
  
  
  const handleSubmit = async () => {
    try {
      if (!props.isUpdate) {
        await costumAPI.post(
          "/category",
          {
            name: name.value,
          },
          {
            headers: { Authorization: `Bearer ${authStore.tokenUser}` },
          }
        );
        alert("Category Added Successfully");
        router.push({ name: "Category" });
      } else {
        await costumAPI.put(
          `/category/${route.params.id}`,
          {
            name: name.value,
          },
          {
            headers: { Authorization: `Bearer ${authStore.tokenUser}` },
          }
        );
  
        alert("Category Updated Successfully");
        router.push({ name: "Category" });
      }
    } catch (e) {
      alert("Internal Server Error");
    }
  };
  
  onMounted(() => {
    if (props.isUpdate) {
      CategoryById();
    } 
  });
  </script>
  