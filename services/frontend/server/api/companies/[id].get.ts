export default defineEventHandler(async (event) => {
  const config = useRuntimeConfig();
  const id = getRouterParam(event, "id");
  const result = await $fetch(`${config.apiServerURL}/companies/${id}`);

  return result;
});
