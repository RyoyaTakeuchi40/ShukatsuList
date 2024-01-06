import { useAuth } from "@/composables/useAuth";

export default defineNuxtRouteMiddleware((to, from) => {
  const { loggedIn } = useAuth();
  if (!loggedIn.value && !(to.path == "/login" || to.path == "/register")) {
    return navigateTo("/login");
  }
});
