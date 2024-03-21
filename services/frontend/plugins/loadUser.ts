export default defineNuxtPlugin(async (nuxtApp) => {
  const { isLoggedIn, fetchUser } = useAuth();

  if (!isLoggedIn) {
    await fetchUser();
  }
});
