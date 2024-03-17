export default defineEventHandler(async (event) => {
  const config = useRuntimeConfig();
  const id = getRouterParam(event, "id");
  const body = await readBody(event);
  const result = await $fetch(
    `${config.apiServerURL}/companies/${id}/favorite`,
    {
      method: "POST",
      body: body,
    }
  );

  return result;
});
