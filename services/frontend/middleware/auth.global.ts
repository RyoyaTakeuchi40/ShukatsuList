export default defineNuxtRouteMiddleware(async (to, from) => {
  const { isLoggedIn, fetchUser } = useAuth();

  if (to.path === "/login" || to.path === "/register") {
    return true;
  }

  if (!isLoggedIn.value) {
    await fetchUser();
  }

  if (!isLoggedIn.value) {
    return navigateTo("/login");
  }
});
