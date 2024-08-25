<template>
    <div>
      <div class="divider divider-neutral">
        <h1 class="text-3xl font-bold text-neutral">Book Category</h1>
      </div>
      <div class="flex justify-end" v-if="authStore.currentUser?.role_id === '9ca92327-a94b-4bf3-9808-068c242c9731'">
        <RouterLink :to="{ name: 'CreateCategory' }" class="btn btn-neutral">Add Category</RouterLink>
      </div>
      <div class="grid md:grid-cols-2 lg:grid-cols-3 mt-3 gap-4">
        <div class="card glass" v-for="category in categories" :key="category.id" v-if="categories">
          <div class="card-body shadow-xl rounded-xl">
            <h2 class="card-title text-center md:text-left">{{ category.name }}</h2>
            <div class="card-actions justify-center md:justify-end">
              <div class="flex justify-center md:justify-end">
                <RouterLink class="btn btn-neutral" :to="{ name: 'DetailCategory', params: { id: category.id } }">
                  Details
                </RouterLink>
              </div>
              <div class="card-actions justify-center md:justify-end">
                <RouterLink class="btn btn-success" :to="{ name: 'UpdateCategory', params: { id: category.id } }"
                  v-if="authStore.currentUser.role_id === '9ca92327-a94b-4bf3-9808-068c242c9731'">
                  Update
                </RouterLink>
              </div>
              <div class="card-actions justify-center md:justify-end">
                <button class="btn btn-warning" @click="handleDelete(category.id)"
                  v-if="authStore.currentUser.role_id === '9ca92327-a94b-4bf3-9808-068c242c9731'">
                  Delete
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { RouterLink } from "vue-router";
  import costumAPI from "@/api";
  import { onMounted, ref } from "vue";
  import { useAuthStore } from "@/stores/AuthStore";
  
  const authStore = useAuthStore();
  const categories = ref("");
  
  const FetchCategories = async () => {
    const response = await costumAPI.get("/category");
    categories.value = response.data.data;
  };
  
  const handleDelete = async (id) => {
    try {
      const response = await costumAPI.delete(`/category/${id}`, {
        headers: { Authorization: `Bearer ${authStore.tokenUser}` },
      });
  
      alert(response.data?.message || "Category Deleted Successfully"); 
      FetchCategories();
    } catch (error) {
      alert("Internal Server Error");
    }
  };
  
  onMounted(() => {
    FetchCategories();
  });
  </script>
  