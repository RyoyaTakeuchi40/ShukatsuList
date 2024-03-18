export default defineEventHandler(async (event) => {
  const config = useRuntimeConfig();
  const token = getCookie(event, "token");
  const id = getRouterParam(event, "id");
  const result = await $fetch(`${config.apiServerURL}/companies/${id}`, {
    headers: {
      Authorization: `Bearer ${token}`,
    },
  });

  return result;
});
