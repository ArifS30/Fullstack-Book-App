<template>
    <AuthHeader />
    <main class="mx-auto max-w-6xl px-8 py-8 my-10 rounded-xl min-h-[80vh]">
      <div class="bg-white shadow-md rounded-lg max-w-3xl px-6 py-10  mx-auto">
        <h1 class="text-center text-3xl font-bold mb-5">{{ props.title }}</h1>
        <div v-if="AuthStore.isError" role="alert" class="alert alert-error my-3">
          <span>{{ AuthStore.errorMsg }}</span>
        </div>
        <form @submit.prevent="handleSubmit()">
          <div class="my-5" v-if="props.isRegister">
            <label class="input input-bordered flex items-center gap-2">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 16 16"
                fill="currentColor"
                class="h-4 w-4 opacity-70"
              >
                <path
                  d="M2.5 3A1.5 1.5 0 0 0 1 4.5v.793c.026.009.051.02.076.032L7.674 8.51c.206.1.446.1.652 0l6.598-3.185A.755.755 0 0 1 15 5.293V4.5A1.5 1.5 0 0 0 13.5 3h-11Z"
                />
                <path
                  d="M15 6.954 8.978 9.86a2.25 2.25 0 0 1-1.956 0L1 6.954V11.5A1.5 1.5 0 0 0 2.5 13h11a1.5 1.5 0 0 0 1.5-1.5V6.954Z"
                />
              </svg>
              <input type="text" class="grow" placeholder="Username" v-model="userInput.name" />
            </label>
          </div>
          <label class="input input-bordered flex items-center gap-2">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 16 16"
              fill="currentColor"
              class="h-4 w-4 opacity-70"
            >
              <path
                d="M2.5 3A1.5 1.5 0 0 0 1 4.5v.793c.026.009.051.02.076.032L7.674 8.51c.206.1.446.1.652 0l6.598-3.185A.755.755 0 0 1 15 5.293V4.5A1.5 1.5 0 0 0 13.5 3h-11Z"
              />
              <path
                d="M15 6.954 8.978 9.86a2.25 2.25 0 0 1-1.956 0L1 6.954V11.5A1.5 1.5 0 0 0 2.5 13h11a1.5 1.5 0 0 0 1.5-1.5V6.954Z"
              />
            </svg>
            <input type="text" class="grow" placeholder="Email" v-model="userInput.email" />
          </label>
          <label class="input input-bordered flex items-center gap-2 my-5">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 16 16"
              fill="currentColor"
              class="h-4 w-4 opacity-70"
            >
              <path
                fill-rule="evenodd"
                d="M14 6a4 4 0 0 1-4.899 3.899l-1.955 1.955a.5.5 0 0 1-.353.146H5v1.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-2.293a.5.5 0 0 1 .146-.353l3.955-3.955A4 4 0 1 1 14 6Zm-4-2a.75.75 0 0 0 0 1.5.5.5 0 0 1 .5.5.75.75 0 0 0 1.5 0 2 2 0 0 0-2-2Z"
                clip-rule="evenodd"
              />
            </svg>
            <input type="password" class="grow" placeholder="Password" v-model="userInput.password" />
          </label>
          <div class="my-5" v-if="props.isRegister">
            <label class="input input-bordered flex items-center gap-2 my-5">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 16 16"
                fill="currentColor"
                class="h-4 w-4 opacity-70"
              >
                <path
                  fill-rule="evenodd"
                  d="M14 6a4 4 0 0 1-4.899 3.899l-1.955 1.955a.5.5 0 0 1-.353.146H5v1.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-2.293a.5.5 0 0 1 .146-.353l3.955-3.955A4 4 0 1 1 14 6Zm-4-2a.75.75 0 0 0 0 1.5.5.5 0 0 1 .5.5.75.75 0 0 0 1.5 0 2 2 0 0 0-2-2Z"
                  clip-rule="evenodd"
                />
              </svg>
              <input type="password" class="grow" placeholder="Password Confirmation" v-model="userInput.password_confirmation" />
            </label>
          </div>
          <input type="submit" class="btn btn-neutral btn-block" :value="props.title" />
          <div v-if="props.isRegister">
            <p>Do you already have an account? Please <a href="/login" class="link link-neutral link-hover">Login</a></p>
          </div>
          <div v-else="">
            <p>Don't you have an account? Please <a href="/register" class="link link-neutral link-hover">Register</a></p>
          </div>
        </form>
      </div>
    </main>
  </template>
  
  <script setup>
  import AuthHeader from '@/components/auth/AuthHeader.vue';
  import { useAuthStore } from '@/stores/AuthStore';
  import { reactive } from 'vue';
  
  const AuthStore = useAuthStore();
  
  const userInput = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
  });
  
  const { loginUser, registerUser } = AuthStore;
  const handleSubmit = () => {
    if (props.isRegister) {
      registerUser(userInput);
    } else {
      loginUser(userInput);
    }
  };
  
  const props = defineProps({
    title: {
      type: String,
      required: true,
    },
    isRegister: {
      type: Boolean,
      default: false,
    },
  });
  </script>