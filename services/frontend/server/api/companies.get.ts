export default defineEventHandler(async (event) => {
  const config = useRuntimeConfig();
  const token = getCookie(event, "token");
  const result = await $fetch(`${config.apiServerURL}/companies`, {
    headers: {
      Authorization: `Bearer ${token}`,
    },
  });

  return result;
});