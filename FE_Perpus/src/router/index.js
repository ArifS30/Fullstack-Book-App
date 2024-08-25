import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/stores/AuthStore";
import HomeView from "../views/HomeView.vue";
import PublicLayout from "@/layouts/PublicLayout.vue";
import BookView from "@/views/BookView.vue";
import CategoryView from "@/views/CategoryView.vue";
import LoginView from "@/views/Auth/LoginView.vue";
import RegisterView from "@/views/Auth/RegisterView.vue";
import ProfileView from "@/views/ProfileView.vue";
import CreateCategoryView from "@/views/CreateCategoryView.vue";
import DetailCategoryView from "@/views/DetailCategoryView.vue";
import UpdateCategoryView from "@/views/UpdateCategoryView.vue";
import CreateBookView from "@/views/CreateBookView.vue";
import UpdateBookView from "@/views/UpdateBookView.vue";
import BorrowView from "@/views/BorrowView.vue";
import UpdateProfileView from "@/views/UpdateProfileView.vue";
import AllBorrowView from "@/views/AllBorrowView.vue";
import DetailBookView from "@/views/DetailBookView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      component: PublicLayout,
      children: [
        {
          path: "/",
          name: "Home",
          component: HomeView,
        },
        {
          path: "/book",
          name: "Book",
          component: BookView,
        },
        {
          path: "/book/create",
          name: "CreateBook",
          component: CreateBookView,
        },
      
        {
          path: "/book/:id",
          name: "DetailBook",
          component: DetailBookView,
        },
        {
          path: "/book/:id/update",
          name: "UpdateBook",
          component: UpdateBookView,
        },
        {
          path: "/category",
          name: "Category",
          component: CategoryView,
        },
        {
          path: "/category/create",
          name: "CreateCategory",
          component: CreateCategoryView,
        },
        {
          path: "/category/:id",
          name: "DetailCategory",
          component: DetailCategoryView,
        },
        {
          path: "/category/:id/update",
          name: "UpdateCategory",
          component: UpdateCategoryView,
        },
        {
          path: "/borrow",
          name: "Borrow",
          component: BorrowView,
        },
        {
          path: "/borrow/all",
          name: "AllBorrow",
          component: AllBorrowView,
        },
        {
          path: "/profile",
          name: "Profile",
          component: ProfileView,
        },
        {
          path: "/profile/update",
          name: "UpdateProfile",
          component: UpdateProfileView,
        },
      ],
    },
    {
      path: "/login",
      name: "Login",
      component: LoginView,
      meta: { requiredAuth: true },
    },
    {
      path: "/register",
      name: "Register",
      component: RegisterView,
      meta: { requiredAuth: true },
    },
  ],
});

router.beforeEach(async (to) => {
  const authStore = await useAuthStore();
  if (to.meta.requiredAuth && authStore.tokenUser) {
    alert("Anda Sudah Login");
    return {
      path: "/",
    };
  }
});

export default router;
