<template>
  <nav class="text-white">
    <div class="navbar bg-neutral">
      <div>
        <div class="dropdown lg:hidden">
          <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
            </svg>
          </div>
          <ul tabindex="0"
            class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow text-black">
            <li v-for="item in listNav" :key="item.id">
              <RouterLink :to="item.link" class="mr-2 hover:text-stone-800">{{
                item.name
                }}</RouterLink>
            </li>
          </ul>
        </div>
      </div>
      <div class="navbar-start">
        <RouterLink to="/" class="btn btn-ghost">
          <img :src="image" class="h-8 w-auto" />
        </RouterLink>
        <ul class="hidden lg:flex lg:items-center">
          <li v-for="item in listNav" :key="item.id">
            <RouterLink :to="item.link" class="mr-2 hover:text-stone-800">{{
              item.name
              }}</RouterLink>
          </li>
          <li
          v-if="authStore.currentUser && authStore.currentUser.role_id === '9ca92327-a94b-4bf3-9808-068c242c9731'">
            <RouterLink to="/borrow/all" class="mr-2 hover:text-stone-800"
           >List Of Borrow</RouterLink>
          </li>
        </ul>
      </div>
      <div class="navbar-end" v-if="authStore.tokenUser">
        <div class="dropdown dropdown-end text-neutral">
          <div tabindex="0" role="button" class="btn btn-info btn-circle avatar">
            <div class="mt-4 text-white">
                <span>{{ authStore.currentUser.name }}</span>
            </div>
          </div>
          <ul tabindex="0"
            class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
            <li>
              <RouterLink to="/profile">Profile</RouterLink>
            </li>
            <li><a @click="handleLogout">Logout</a></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import image from "@/assets/bb.png";
import { useAuthStore } from "@/stores/AuthStore";

const authStore = useAuthStore();

const handleLogout = () => {
  authStore.logoutUser();
};

const listNav = [
  {
    id: 1,
    name: "Book",
    link: "/book",
  },
  {
    id: 2,
    name: "Category",
    link: "/category",
  },
];
</script>