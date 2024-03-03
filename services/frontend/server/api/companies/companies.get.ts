export default defineEventHandler(async (event) => {
  const config = useRuntimeConfig();
  const result = await $fetch(`${config.apiServerURL}/companies`);

  return result;
});
