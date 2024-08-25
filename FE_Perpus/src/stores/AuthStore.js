import { ref } from "vue";
import { defineStore } from "pinia";
import { useRouter } from "vue-router";
import costumAPI from "@/api";

export const useAuthStore = defineStore("auth", () => {
  const router = useRouter();
  const tokenUser = ref(
    localStorage.getItem("token")
      ? JSON.parse(localStorage.getItem("token"))
      : null
  );

  const currentUser = ref(
    localStorage.getItem("user")
      ? JSON.parse(localStorage.getItem("user"))
      : null
  );

  const isError = ref(false);
  const errorMsg = ref("");
  const loginUser = async (inputData) => {
    try {
      isError.value = false;
      errorMsg.value = "";

      const { email, password } = inputData;

      const { data } = await costumAPI.post("/auth/login", {
        email: email,
        password: password,
      });

      const { token, user } = data;

      console.log(token, user);

      //pinia
      tokenUser.value = token;
      currentUser.value = user;

      // localStorage

      localStorage.setItem("token", JSON.stringify(token));
      localStorage.setItem("user", JSON.stringify(user));

      router.push({ name: "Home" });
    } catch (error) {
      isError.value = true;
      errorMsg.value = error.response.data.message;
    }
  };

  const registerUser = async (inputData) => {
    try {
      isError.value = false;
      errorMsg.value = "";

      const { name, email, password, password_confirmation } = inputData;

      const { data } = await costumAPI.post("/auth/register", {
        name: name,
        email: email,
        password: password,
        password_confirmation: password_confirmation,
      });

      const { token, user } = data;

      //pinia
      tokenUser.value = token;
      currentUser.value = user;

      // localStorage

      localStorage.setItem("token", JSON.stringify(token));
      localStorage.setItem("user", JSON.stringify(user));

      router.push({ name: "Home" });
    } catch (error) {
      isError.value = true;
      errorMsg.value = error.response.data;
    }
  };

  const getMe = async () => {
    try {
      const { data } = await costumAPI.get("/me", {
        headers: {
          Authorization: `Bearer ${tokenUser.value}`,
        },
      });

      const { user } = data;

      //localStorage
      localStorage.setItem("user", JSON.stringify(user));
      currentUser.value = user;
    } catch (error) {
      console.log(error);
    }
  };

  const logoutUser = async () => {
    const res = await costumAPI.post("/auth/logout", null, {
      headers: { Authorization: `Bearer ${tokenUser.value}` },
    });
    console.log(res);

    //localStorage
    localStorage.removeItem("token");
    localStorage.removeItem("user");

    //pinia
    tokenUser.value = "";
    currentUser.value = "";

    router.push({ name: "Home" });
  };
  const updateUser = async (response) => {
    try {
      const user = localStorage.getItem("user");

      if (user) {
        const parsedUser = JSON.parse(user);
        parsedUser.profile = response;
        localStorage.setItem("user", JSON.stringify(parsedUser));
      }

      console.log("Bio And Age updated successfully!");
    } catch (error) {
      console.log(error);
    }
  };
  return {
    tokenUser,
    currentUser,
    loginUser,
    isError,
    errorMsg,
    getMe,
    logoutUser,
    registerUser,
    updateUser,
  };
});
