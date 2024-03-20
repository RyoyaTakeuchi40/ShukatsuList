export default defineEventHandler(async (event) => {
  const config = useRuntimeConfig();
  const token = getCookie(event, "token");
  const result = await $fetch(`${config.apiServerURL}/logout`, {
    headers: {
      Authorization: `Bearer ${token}`,
    },
    method: "POST",
  });

  setCookie(event, "token", "", { path: "http://localhost/" });

  return result;
});
