<template>
    <header class="bg-neutral text-white">
      <div class="mx-auto max-w-8xl">
        <nav class="flex justify-end items-center">
          <ul class="flex">
            <li>
              <RouterLink to="/login" class="mr-3 hover:text-stone-800"
                >Login</RouterLink
              >
            </li>
            <li>
              <RouterLink to="/register" class="mr-3 hover:text-stone-800"
                >Register</RouterLink
              >
            </li>
          </ul>
        </nav>
      </div>
    </header>
  </template>
  
  <script setup>
  import { RouterLink } from "vue-router";
  </script>
  