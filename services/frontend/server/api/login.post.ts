export default defineEventHandler(async (event) => {
  const config = useRuntimeConfig();
  const body = await readBody(event);
  const result = await $fetch(`${config.apiServerURL}/login`, {
    method: "POST",
    body: body,
  });

  // tokenをcookieに保存
  const devidePoint = result.token.indexOf("|") + 1;
  const token = result.token.substring(devidePoint);
  setCookie(event, "token", token);

  return result;
});
