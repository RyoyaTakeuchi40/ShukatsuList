export default defineNuxtRouteMiddleware((to, from) => {
  const isAuth = useAuth();

  if (to.path === "/login" || to.path === "/register") {
    return true;
  } else if (!isAuth.value) {
    return navigateTo("/login");
  }
});
