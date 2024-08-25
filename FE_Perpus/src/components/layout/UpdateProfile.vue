<template>
  <div class="bg-white shadow-md rounded-lg max-w-3xl px-6 py-20 mx-auto flex justify-center items-center">
    <div>
      <h1 class="text-center text-3xl font-bold mb-5">Update Profile</h1>
      <form @submit.prevent="updateProfile">
        <div class="mb-4">
          <label for="bio" class="input input-bordered flex items-center gap-2">
            <input type="text" class="grow" placeholder="Bio" v-model="bio" required />
          </label>
        </div>
        <div class="mb-4">
          <label for="age" class="input input-bordered flex items-center gap-2">
            <input type="age" class="grow" placeholder="Age" v-model="age" required />
          </label>
        </div>
        <button type="submit" class="btn btn-neutral btn-block mt-5 text-white">Update Profile</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { useAuthStore } from '@/stores/AuthStore';
import { ref } from 'vue';
import costumAPI from '@/api';
import { useRouter } from 'vue-router';

const authStore = useAuthStore();
const router = useRouter();


const age = ref(authStore.currentUser.age);
const bio = ref(authStore.currentUser.bio);

const updateProfile = async () => {
  try {
    const response = await costumAPI.post('/auth/profile', {
      age: age.value,
      bio: bio.value,
    }, {
      headers: {
        Authorization: `Bearer ${authStore.tokenUser}`,
      },
    });

    if (response.data.message === 'Profile updated!') {

      authStore.updateUser(response.data.data);
      alert('Profile updated successfully!');

      router.push({ name: 'Profile' });
    } else {
      alert('Failed to update profile.');
    }
  } catch (error) {
    console.error('Error updating profile:', error);
    alert(' error while updating the profile.');
  }
};
</script>