export default defineEventHandler(async () => {
  const config = useRuntimeConfig();
  const result = await $fetch(`${config.apiServerURL}/check`);

  return result;
});
