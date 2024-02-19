export default defineEventHandler(async (event) => {
  const config = useRuntimeConfig();
  const query = getQuery(event);
  const result = await $fetch(`${config.apiServerURL}/companies`, {
    query: { user_id: query.userId },
  });

  return result;
});
