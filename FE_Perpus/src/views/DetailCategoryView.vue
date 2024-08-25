<template>
    <section v-if="category">
      <div class="divider divider-neutral">
        <h1 class="text-3xl font-bold text-neutral">{{ category.name }}</h1>
      </div>
      <div class="container mx-auto pb-2">
        <div class="card rounded-box grid h-full place-items-center"  v-if="category.list_books.length">
            <div
              class="grid md:grid-cols-2 lg:grid-cols-3 mt-3 gap-4"
            >
              <div
                class="card glass "
                v-for="(item, index) in category.list_books"
                :key="index"
              >
                      <div class="w-full h-96 overflow-hidden rounded-xl">
                  <img :src="item.image" class="object-cover w-full h-full" />
                </div>
                <div
                  class="absolute bottom-0 left-0 w-full bg-neutral bg-opacity-75 text-center py-2"
                >
                  <div class="font-bold">{{ item.title }}</div>
                  <RouterLink class="btn btn-info" :to="{ name: 'Borrow', }">Borrow</RouterLink>

                </div>
              </div>
            </div>
          </div>
          <div v-else>
          <h1 class="text-3xl font-bold text-neutral">No Book Found</h1>
        </div>
        </div>
    </section>
  </template>
  
  <script setup>
  import { RouterLink } from "vue-router";
  import costumAPI from "@/api";
  import { ref, onMounted } from "vue";
  import { useRoute } from "vue-router";
  
  
  const route = useRoute();
  const category = ref(null);
  
  const CategoryById = async () => {
    const { data } = await costumAPI(`/category/${route.params.id}`);
    category.value = data.data;
  };
  onMounted(() => {
    CategoryById();
  });
  </script>
  