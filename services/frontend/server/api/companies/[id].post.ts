export default defineEventHandler(async (event) => {
  const config = useRuntimeConfig();
  const token = getCookie(event, "token");
  const id = getRouterParam(event, "id");
  const body = await readBody(event);
  const result = await $fetch(`${config.apiServerURL}/companies/${id}`, {
    headers: {
      Authorization: `Bearer ${token}`,
    },
    method: "POST",
    body: body,
  });

  return result;
});
