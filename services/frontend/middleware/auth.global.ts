export default defineNuxtRouteMiddleware((to, from) => {
  const { isLoggedIn } = useAuth();

  if (to.path === "/login" || to.path === "/register") {
    return true;
  } else if (!isLoggedIn.value) {
    return navigateTo("/login");
  }
});
