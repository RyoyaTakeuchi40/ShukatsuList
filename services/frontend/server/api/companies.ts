export default defineEventHandler(async (event) => {
  const config = useRuntimeConfig();
  const query = getQuery(event);
  console.log(`API Server : ${config.apiServerURL}`);
  const result = await $fetch(`${config.apiServerURL}/companies`, {
    query: { user_id: 2 },
  });

  return result;
});
